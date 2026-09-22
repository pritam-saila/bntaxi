<?php

namespace App\Http\Controllers\Concerns;

use App\Exceptions\DriverDocumentException;
use App\Models\DriverDocument;
use App\Models\DriverProfile;
use App\Models\User;
use App\Services\DriverDocumentService;
use App\Services\DriverDocumentStorage;
use App\Services\DriverVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\HeaderUtils;

/**
 * Behaviour shared by the driver-facing and admin-facing documentation screens.
 * The using controller says which one it is via mode() and hands us the driver
 * being acted on - it is responsible for making sure the caller may act on them.
 */
trait ManagesDriverDocumentation
{
    private const PHONE_RULE = '/^\+?[0-9()\s-]{7,20}$/';

    /** 'driver' or 'admin' */
    abstract protected function mode(): string;

    protected function verification(): DriverVerificationService
    {
        return app(DriverVerificationService::class);
    }

    protected function documents(): DriverDocumentService
    {
        return app(DriverDocumentService::class);
    }

    /** Unknown / mistyped document types are a 404, not a 500. */
    protected function documentType(string $type): array
    {
        $def = config("driver_documents.types.{$type}");
        abort_unless($def, 404);

        return $def;
    }

    protected function renderPage(User $driver, string $view = 'driver-documents.manage')
    {
        return response()
            ->view($view, $this->verification()->pageData($driver, $this->mode()))
            ->header('Cache-Control', 'no-store, private');
    }

    // ------------------------------------------------------------------
    // Details forms (redirect-and-flash; each has its own error bag)
    // ------------------------------------------------------------------

    protected function storeDetails(Request $request, User $driver): RedirectResponse
    {
        $data = $request->validateWithBag('details', [
            'name'                    => ['required', 'string', 'max:255'],
            'email'                   => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($driver->id)],
            'phone'                   => ['required', 'string', 'regex:' . self::PHONE_RULE],
            'emergency_contact_name'  => ['required', 'string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'regex:' . self::PHONE_RULE],
        ], [
            'phone.regex'                   => 'Enter a valid contact number (digits, spaces, + ( ) - only).',
            'emergency_contact_phone.regex' => 'Enter a valid emergency contact number (digits, spaces, + ( ) - only).',
            'email.unique'                  => 'That email address is already used by another account.',
        ]);

        $driver->update(['name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone']]);
        DriverProfile::updateOrCreate(['user_id' => $driver->id], [
            'emergency_contact_name'  => $data['emergency_contact_name'],
            'emergency_contact_phone' => $data['emergency_contact_phone'],
        ]);

        return $this->saved('details', 'Driver information saved.');
    }

    protected function storeVehicle(Request $request, User $driver): RedirectResponse
    {
        $data = $request->validateWithBag('vehicle', [
            'make'         => ['required', 'string', 'max:100'],
            'model'        => ['required', 'string', 'max:100'],
            'vehicle_year' => ['required', 'integer', 'between:1980,' . (now()->year + 1)],
        ], [
            'vehicle_year.between' => 'Enter a valid vehicle year.',
        ]);

        $driver->update(['make' => $data['make'], 'model' => $data['model']]);
        DriverProfile::updateOrCreate(['user_id' => $driver->id], ['vehicle_year' => $data['vehicle_year']]);

        return $this->saved('vehicle', 'Vehicle information saved.');
    }

    protected function storeBank(Request $request, User $driver): RedirectResponse
    {
        $profile = DriverProfile::firstOrNew(['user_id' => $driver->id]);

        // People type account numbers and sort codes with spaces and dashes.
        $request->merge([
            'bank_account_number' => preg_replace('/[\s-]+/', '', (string) $request->input('bank_account_number')),
            'bank_sort_code'      => preg_replace('/[\s-]+/', '', (string) $request->input('bank_sort_code')),
        ]);

        // The stored number / sort code are never sent back to the browser, so a
        // blank field means "keep what's saved".
        $keepNumber = filled($profile->bank_account_number);
        $keepSort   = filled($profile->bank_sort_code);

        $data = $request->validateWithBag('bank', [
            'bank_account_holder' => ['required', 'string', 'max:120'],
            'bank_name'           => ['required', 'string', 'max:100'],
            'bank_account_number' => [$keepNumber ? 'nullable' : 'required', 'regex:/^\d{8}$/'],
            'bank_sort_code'      => [$keepSort ? 'nullable' : 'required', 'regex:/^\d{6}$/'],
        ], [
            'bank_account_number.regex' => 'A UK account number is 8 digits.',
            'bank_sort_code.regex'      => 'A sort code is 6 digits, e.g. 12-34-56.',
        ]);

        $profile->bank_account_holder = $data['bank_account_holder'];
        $profile->bank_name           = $data['bank_name'];
        if (filled($data['bank_account_number'] ?? null)) {
            $profile->bank_account_number = $data['bank_account_number'];
        }
        if (filled($data['bank_sort_code'] ?? null)) {
            $profile->bank_sort_code = $data['bank_sort_code'];
        }
        $profile->save();

        // Audit that it changed - never what it changed to.
        Log::info('driver.bank_details_updated', ['driver_id' => $driver->id, 'by' => auth()->id()]);

        return $this->saved('bank', 'Bank details saved securely.');
    }

    private function saved(string $section, string $message): RedirectResponse
    {
        return back()->with('dd_success', $message)->with('dd_section', $section);
    }

    // ------------------------------------------------------------------
    // Documents (JSON - driven by XHR so the page never reloads)
    // ------------------------------------------------------------------

    protected function storeDocument(Request $request, User $driver, string $type): JsonResponse
    {
        $this->documentType($type);

        $validator = Validator::make($request->all(), [
            'document' => [
                'required', 'file',
                'max:' . config('driver_documents.max_size_kb'),
                'mimes:' . implode(',', config('driver_documents.allowed_extensions')),
                'mimetypes:' . implode(',', config('driver_documents.allowed_mimes')),
            ],
        ], [
            'document.required'  => 'Choose a file to upload.',
            'document.uploaded'  => 'The file couldn\'t be uploaded. It may be larger than the server allows.',
            'document.max'       => 'The file is too large. The maximum size is ' . round(config('driver_documents.max_size_kb') / 1024) . ' MB.',
            'document.mimes'     => 'Only PDF, JPG, JPEG and PNG files are accepted.',
            'document.mimetypes' => 'Only PDF, JPG, JPEG and PNG files are accepted.',
        ]);

        if ($validator->fails()) {
            return response()->json(['ok' => false, 'message' => $validator->errors()->first('document')], 422);
        }

        try {
            $doc = $this->documents()->upload(
                $driver,
                $type,
                $request->file('document'),
                $request->user(),
                $request->boolean('confirm_replace')
            );
        } catch (DriverDocumentException $e) {
            return response()->json(['ok' => false, 'reason' => $e->reason, 'message' => $e->getMessage()], $e->status);
        } catch (\RuntimeException $e) {
            // The stored-file sniffing rejected it (e.g. a renamed non-PDF).
            return response()->json(['ok' => false, 'message' => 'That file isn\'t a valid PDF, JPG or PNG.'], 422);
        }

        return $this->documentResponse($driver, $type, 'Document uploaded.');
    }

    protected function removeDocument(Request $request, User $driver, DriverDocument $document): JsonResponse
    {
        try {
            $this->documents()->delete($document, $request->user());
        } catch (DriverDocumentException $e) {
            return response()->json(['ok' => false, 'reason' => $e->reason, 'message' => $e->getMessage()], $e->status);
        }

        return $this->documentResponse($driver, $document->type, 'Document removed.');
    }

    /** Fresh HTML for the changed card and the summary panel, rendered by the same Blade partials. */
    protected function documentResponse(User $driver, string $type, string $message): JsonResponse
    {
        $data = $this->verification()->pageData($driver->fresh(), $this->mode());

        return response()->json([
            'ok'      => true,
            'message' => $message,
            'card'    => view('driver-documents.partials.card', $data + [
                'type' => $type,
                'def'  => $data['groups'][config("driver_documents.types.{$type}.group")][$type],
                'doc'  => $data['docs']->get($type),
            ])->render(),
            'summary' => view('driver-documents.partials.summary', $data)->render(),
        ])->header('Cache-Control', 'no-store');
    }

    /**
     * Stream a decrypted document. Callers must already have authorised access
     * to $document. Nothing is cached anywhere, the type is pinned with nosniff.
     */
    protected function streamDocument(Request $request, DriverDocument $document): Response
    {
        $thumb = $request->boolean('thumb') && $document->thumb_path;
        $bytes = app(DriverDocumentStorage::class)->read($thumb ? $document->thumb_path : $document->path);
        abort_if($bytes === null, 404);

        $name       = $document->original_name;
        $fallback   = str_replace(['%', '/', '\\'], '_', Str::ascii($name));
        $disposition = HeaderUtils::makeDisposition(
            $request->boolean('download') ? HeaderUtils::DISPOSITION_ATTACHMENT : HeaderUtils::DISPOSITION_INLINE,
            $name,
            $fallback
        );

        if (!$thumb && $this->mode() === 'admin') {
            Log::info('driver_document.accessed', ['document' => $document->uuid, 'driver_id' => $document->user_id, 'by' => auth()->id()]);
        }

        return response($bytes, 200, [
            'Content-Type'           => $thumb ? 'image/jpeg' : $document->mime,
            'Content-Disposition'    => $disposition,
            'Content-Length'         => strlen($bytes),
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options'        => 'SAMEORIGIN',
            'Referrer-Policy'        => 'no-referrer',
            'Cache-Control'          => 'private, no-store, max-age=0',
        ]);
    }
}
