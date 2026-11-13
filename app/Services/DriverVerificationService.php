<?php

namespace App\Services;

use App\Models\DriverDocument;
use App\Models\DriverProfile;
use App\Models\User;
use App\Support\DriverDocumentRoutes;

/**
 * Works out a driver's overall documentation status and builds the data the
 * shared driver/admin documentation screen renders.
 */
class DriverVerificationService
{
    public const INCOMPLETE          = 'incomplete';
    public const DOCUMENTS_SUBMITTED = 'documents_submitted';
    public const UNDER_REVIEW        = 'under_review';
    public const PARTIALLY_APPROVED  = 'partially_approved';
    public const VERIFIED            = 'verified';
    public const REQUIRES_ACTION     = 'requires_action';

    /** status => [label, tone (maps to a CSS modifier), one-line explanation] */
    public const STATUSES = [
        self::INCOMPLETE          => ['Incomplete',          'muted',   'Some required details or documents are still missing.'],
        self::DOCUMENTS_SUBMITTED => ['Documents Submitted', 'info',    'Everything required has been submitted and is waiting for review.'],
        self::UNDER_REVIEW        => ['Under Review',        'warning', 'An administrator is reviewing the submitted documents.'],
        self::PARTIALLY_APPROVED  => ['Partially Approved',  'info',    'Some required documents are approved; the rest are still being reviewed.'],
        self::VERIFIED            => ['Verified',            'success', 'All required details and documents are approved.'],
        self::REQUIRES_ACTION     => ['Requires Action',     'danger',  'One or more items need attention before verification can continue.'],
    ];

    /**
     * An active driver whose overall status is "Requires Action" has a required
     * document that's expired, rejected, or gone missing after being approved -
     * they must not be able to pick up new jobs until it's sorted out. This is
     * live off today's date (see DriverDocument::effectiveStatus()), so a
     * document simply reaching its expiry date blocks them automatically, with
     * no admin action needed.
     *
     * Uploading a corrected document lifts the block straight away, ahead of
     * admin review (it moves out of "Requires Action" into "Under Review" /
     * "Partially Approved") - if the admin then rejects it, that puts the
     * driver straight back into "Requires Action" and blocks them again.
     * This deliberately does NOT apply to a driver who was force-activated by
     * an admin despite incomplete verification (config('driver_documents')
     * status INCOMPLETE / DOCUMENTS_SUBMITTED, not REQUIRES_ACTION) - that's
     * an explicit admin override, not something this should second-guess.
     */
    public function blocksNewJobs(User $driver): bool
    {
        return $this->overall($driver)['status'] === self::REQUIRES_ACTION;
    }

    /** @return array<string,array> document type => config */
    public function types(): array
    {
        return config('driver_documents.types', []);
    }

    /** Has the driver filled in every mandatory detail, per section? */
    public function detailsComplete(User $driver): array
    {
        $profile = $driver->driverProfile ?? new DriverProfile();

        return [
            'driver'  => filled($driver->name) && filled($driver->email) && filled($driver->phone)
                         && filled($profile->emergency_contact_name) && filled($profile->emergency_contact_phone),
            'bank'    => $profile->hasBankDetails(),
            'vehicle' => filled($driver->make) && filled($driver->model) && filled($profile->vehicle_year),
        ];
    }

    /**
     * The driver's overall documentation status plus the checklist behind it.
     *
     * Precedence (first match wins):
     *   1. a required document is rejected or expired ......... Requires Action
     *   2. something required is missing:
     *        - and at least one document is already approved ... Requires Action
     *          (the pack was progressing and now needs the driver)
     *        - otherwise ...................................... Incomplete
     *   3. every required document approved ................... Verified
     *   4. some, but not all, approved ......................... Partially Approved
     *   5. none approved, at least one under review ............ Under Review
     *   6. none approved, all merely uploaded .................. Documents Submitted
     *
     * Optional documents appear in the checklist but never affect the status.
     *
     * @return array{status:string,label:string,tone:string,summary:string,items:array,approved:int,required_total:int,expiring:int}
     */
    public function overall(User $driver): array
    {
        $driver->loadMissing(['driverProfile', 'driverDocuments']);
        $docs    = $driver->driverDocuments->keyBy('type');
        $details = $this->detailsComplete($driver);

        $items = [];
        foreach ([
            'driver'  => 'Driver details',
            'bank'    => 'Bank details',
            'vehicle' => 'Vehicle details',
        ] as $key => $label) {
            $items[] = $details[$key]
                ? $this->item("details_{$key}", $label, 'ok', 'Complete')
                : $this->item("details_{$key}", $label, 'action', 'Required');
        }

        $missing = collect($details)->contains(false);
        $blocked = false;          // a required doc is rejected / expired
        $approvedAny = false;
        $approvedRequired = 0;
        $requiredTotal = 0;
        $underReview = false;
        $expiring = 0;

        foreach ($this->types() as $type => $def) {
            $required = (bool) ($def['required'] ?? false);
            $doc      = $docs->get($type);
            $status   = $doc?->effectiveStatus() ?? DriverDocument::STATUS_NOT_UPLOADED;
            $expiry   = $doc?->expiryInfo();

            if ($required) {
                $requiredTotal++;
            }
            if ($expiry && in_array($expiry['state'], ['warning', 'soon', 'expired'], true)) {
                $expiring++;
            }
            if ($status === DriverDocument::STATUS_APPROVED) {
                $approvedAny = true;
                $approvedRequired += $required ? 1 : 0;
            }

            switch ($status) {
                case DriverDocument::STATUS_APPROVED:
                    $warn = $expiry && in_array($expiry['state'], ['warning', 'soon'], true);
                    $items[] = $this->item($type, $def['short'], 'ok', $warn ? 'Approved — ' . lcfirst($expiry['label']) : 'Approved', $required, $warn);
                    break;

                case DriverDocument::STATUS_UPLOADED:
                case DriverDocument::STATUS_UNDER_REVIEW:
                    $underReview = $underReview || ($required && $status === DriverDocument::STATUS_UNDER_REVIEW);
                    $items[] = $this->item($type, $def['short'], 'pending', $status === DriverDocument::STATUS_UNDER_REVIEW ? 'Under review' : 'Awaiting review', $required);
                    break;

                case DriverDocument::STATUS_REJECTED:
                    $blocked = $blocked || $required;
                    $items[] = $this->item($type, $def['short'], 'action', 'Rejected — re-upload required', $required);
                    break;

                case DriverDocument::STATUS_EXPIRED:
                    $blocked = $blocked || $required;
                    $items[] = $this->item($type, $def['short'], 'action', 'Expired — upload a renewed copy', $required);
                    break;

                default: // not uploaded
                    if ($required) {
                        $missing = true;
                        $items[] = $this->item($type, $def['short'], 'action', 'Required', true);
                    } else {
                        $items[] = $this->item($type, $def['short'], 'optional', 'Optional', false);
                    }
            }
        }

        // Anything required that isn't approved yet (pending, rejected, expired or missing).
        $allApproved = !$missing && !$blocked && $approvedRequired === $requiredTotal;

        $status = match (true) {
            $blocked                   => self::REQUIRES_ACTION,
            $missing && $approvedAny   => self::REQUIRES_ACTION,
            $missing                   => self::INCOMPLETE,
            $allApproved               => self::VERIFIED,
            $approvedAny               => self::PARTIALLY_APPROVED,
            $underReview               => self::UNDER_REVIEW,
            default                    => self::DOCUMENTS_SUBMITTED,
        };

        [$label, $tone, $summary] = self::STATUSES[$status];

        if ($status === self::PARTIALLY_APPROVED) {
            $summary = "{$approvedRequired} of {$requiredTotal} required documents approved; the rest are still being reviewed.";
        }

        return [
            'status'         => $status,
            'label'          => $label,
            'tone'           => $tone,
            'summary'        => $summary,
            'items'          => $items,
            'approved'       => $approvedRequired,
            'required_total' => $requiredTotal,
            'expiring'       => $expiring,
        ];
    }

    /** Everything the shared documentation screen needs. */
    public function pageData(User $driver, string $mode): array
    {
        $driver->load(['driverProfile', 'driverDocuments' => function ($q) use ($mode) {
            if ($mode === 'admin') {
                $q->with(['reviews' => fn ($r) => $r->with('actor:id,name')->limit(50)]);
            }
        }]);

        $profile = $driver->driverProfile ?? new DriverProfile(['user_id' => $driver->id]);

        $groups = [];
        foreach ($this->types() as $type => $def) {
            $groups[$def['group']][$type] = $def;
        }

        return [
            'mode'        => $mode,
            'driver'      => $driver,
            'profile'     => $profile,
            'application' => $profile->application_status,
            'isApplicant' => $mode === 'driver' && $driver->isPendingDriverApplicant(),
            'blockedFromJobs' => $driver->status == 1 && $this->blocksNewJobs($driver),
            'overall' => $this->overall($driver),
            'docs'    => $driver->driverDocuments->keyBy('type'),
            'groups'  => $groups,
            'routes'  => new DriverDocumentRoutes($mode, $driver),
        ];
    }

    private function item(string $key, string $label, string $state, string $note, bool $required = true, bool $warn = false): array
    {
        return [
            'key'      => $key,
            'label'    => $label,
            'state'    => $state,      // ok | pending | action | optional
            'note'     => $note,
            'required' => $required,
            'warn'     => $warn,
        ];
    }
}
