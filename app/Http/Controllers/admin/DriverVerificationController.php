<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Concerns\ManagesDriverDocumentation;
use App\Http\Controllers\Controller;
use App\Models\DriverDocument;
use App\Models\DriverProfile;
use App\Models\User;
use App\Services\DriverVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

/**
 * Admin side of driver documentation: the driver list with each driver's
 * overall status, and the per-driver review screen. Route middleware already
 * restricts this to admins (user-access:admin).
 */
class DriverVerificationController extends Controller
{
    use ManagesDriverDocumentation;

    protected function mode(): string
    {
        return 'admin';
    }

    public function index(Request $request, DriverVerificationService $verification)
    {
        $rows = User::where('type', 2)
            ->with(['driverProfile', 'driverDocuments'])
            ->orderBy('name')
            ->get()
            ->map(fn (User $driver) => ['driver' => $driver, 'overall' => $verification->overall($driver)]);

        $counts = $rows->countBy(fn ($row) => $row['overall']['status']);

        $isPending = fn ($row) => $row['driver']->driverProfile?->application_status === DriverProfile::APPLICATION_PENDING;
        $pendingCount = $rows->filter($isPending)->count();

        $filter = $request->query('status');
        if ($filter && isset(DriverVerificationService::STATUSES[$filter])) {
            $rows = $rows->filter(fn ($row) => $row['overall']['status'] === $filter);
        }

        $onlyPending = $request->query('application') === 'pending';
        if ($onlyPending) {
            $rows = $rows->filter($isPending);
        }

        if ($q = trim((string) $request->query('q'))) {
            $needle = mb_strtolower($q);
            $rows = $rows->filter(fn ($row) => str_contains(mb_strtolower($row['driver']->name . ' ' . $row['driver']->email), $needle));
        }

        return response()->view('driver-documents.admin-index', [
            'rows'     => $rows->values(),
            'counts'   => $counts,
            'statuses' => DriverVerificationService::STATUSES,
            'filter'   => $filter,
            'pendingCount' => $pendingCount,
            'onlyPending'  => $onlyPending,
            'q'        => $q ?? '',
        ]);
    }

    public function show(User $driver)
    {
        return $this->renderPage($this->driver($driver));
    }

    public function details(Request $request, User $driver)
    {
        return $this->storeDetails($request, $this->driver($driver));
    }

    public function vehicle(Request $request, User $driver)
    {
        return $this->storeVehicle($request, $this->driver($driver));
    }

    public function bank(Request $request, User $driver)
    {
        return $this->storeBank($request, $this->driver($driver));
    }

    public function upload(Request $request, User $driver, string $type)
    {
        return $this->storeDocument($request, $this->driver($driver), $type);
    }

    public function file(Request $request, DriverDocument $document)
    {
        return $this->streamDocument($request, $document);
    }

    public function destroy(Request $request, DriverDocument $document)
    {
        return $this->removeDocument($request, $document->driver, $document);
    }

    /** Move everything freshly uploaded into "under review". */
    public function startReview(Request $request, User $driver)
    {
        $count = $this->documents()->startReview($this->driver($driver), $request->user());

        return back()->with(
            'dd_success',
            $count ? "{$count} " . ($count === 1 ? 'document' : 'documents') . ' moved to Under Review.' : 'There are no newly uploaded documents to review.'
        );
    }

    /**
     * The account-level decision on a driver: activate (approve the application),
     * decline it, or deactivate an active driver. Activating a driver whose
     * documents aren't fully verified needs an explicit `force` (the screen asks
     * the admin to confirm first).
     */
    public function decideApplication(Request $request, User $driver, DriverVerificationService $verification)
    {
        $this->driver($driver);

        $data = $request->validate([
            'action' => ['required', Rule::in(['approve', 'decline', 'deactivate'])],
            'force'  => ['nullable', 'boolean'],
        ]);

        $profile   = DriverProfile::firstOrCreate(['user_id' => $driver->id]);
        $decision  = ['application_decided_at' => now(), 'application_decided_by' => $request->user()->id];
        $isApplication = $profile->application_status !== null;

        switch ($data['action']) {
            case 'approve':
                $overall = $verification->overall($driver);
                if ($overall['status'] !== DriverVerificationService::VERIFIED && !$request->boolean('force')) {
                    return back()->with('error', "This driver's documents aren't fully verified yet ({$overall['label']}). Confirm to activate anyway.");
                }
                $driver->update(['status' => 1]);
                if ($isApplication) {
                    $profile->update(['application_status' => DriverProfile::APPLICATION_APPROVED] + $decision);
                }
                $message = 'Account activated. The driver can now log in and accept bookings.';
                break;

            case 'decline':
                if ($profile->application_status !== DriverProfile::APPLICATION_PENDING) {
                    return back()->with('error', 'Only a pending application can be declined.');
                }
                $profile->update(['application_status' => DriverProfile::APPLICATION_DECLINED] + $decision);
                $message = 'Application declined. The driver can no longer log in.';
                break;

            default: // deactivate
                $driver->update(['status' => 0]);
                $message = 'Account deactivated.';
        }

        Log::info('driver.application_decision', ['driver_id' => $driver->id, 'action' => $data['action'], 'by' => $request->user()->id]);

        return back()->with('dd_success', $message);
    }

    /**
     * Approve / reject / request re-upload / save dates / add an internal note.
     * A rejection or re-upload request must carry a reason (the driver sees it);
     * approving a document type that expires needs a current expiry date.
     */
    public function review(Request $request, DriverDocument $document)
    {
        $def    = $document->definition();
        $action = $request->input('action');

        $rules = [
            'action'      => ['required', Rule::in(['approve', 'reject', 'reupload', 'dates', 'note'])],
            'reason'      => ['nullable', 'string', 'max:2000'],
            'note'        => ['nullable', 'string', 'max:2000'],
            'issue_date'  => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
        ];

        if (in_array($action, ['reject', 'reupload'], true)) {
            $rules['reason'] = ['required', 'string', 'max:2000'];
        }
        if ($action === 'note') {
            $rules['note'] = ['required', 'string', 'max:2000'];
        }
        if ($action === 'approve' && !empty($def['has_expiry'])) {
            $rules['expiry_date'] = ['required', 'date', 'after_or_equal:today'];
        }

        // Applies to every action that carries both dates.
        $rules['expiry_date'][] = function ($attribute, $value, $fail) use ($request) {
            $issued = $request->input('issue_date');
            if ($value && $issued && strtotime($value) !== false && strtotime($issued) !== false && strtotime($value) < strtotime($issued)) {
                $fail('The expiry date can\'t be before the issue date.');
            }
        };

        $data = $request->validate($rules, [
            'reason.required'            => $action === 'reupload'
                ? 'Tell the driver what to fix — a reason is required to request a re-upload.'
                : 'A rejection reason is required — the driver will see it.',
            'note.required'              => 'Write the internal note first.',
            'expiry_date.required'       => 'Enter the expiry date before approving this document.',
            'expiry_date.after_or_equal' => 'This document has already expired, so it can\'t be approved. Ask the driver for a current one.',
        ]);

        $this->documents()->review($document, $request->user(), $data);

        $labels = [
            'approve' => 'Document approved.', 'reject' => 'Document rejected.',
            'reupload' => 'Re-upload requested.', 'dates' => 'Dates saved.', 'note' => 'Note added.',
        ];

        return $this->documentResponse($document->driver, $document->type, $labels[$data['action']]);
    }

    /** Only real drivers have documentation - anything else in {driver} is a 404. */
    private function driver(User $user): User
    {
        abort_unless((int) $user->getRawOriginal('type') === 2, 404);

        return $user;
    }
}
