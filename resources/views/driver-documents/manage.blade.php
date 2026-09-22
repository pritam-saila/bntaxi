@include('admin.include.sidebar')

@php
    $admin  = $mode === 'admin';
    $cssVer = @filemtime(public_path('admin/css/driver-documents.css')) ?: 1;
    $jsVer  = @filemtime(public_path('admin/js/driver-documents.js')) ?: 1;

    // Which section should the page scroll to after a save / validation error?
    $scrollTo = session('dd_section')
        ?: ($errors->getBag('details')->any() ? 'details'
        : ($errors->getBag('bank')->any() ? 'bank'
        : ($errors->getBag('vehicle')->any() ? 'vehicle' : null)));

    $needsReview = $docs->contains(fn ($d) => $d->status === 'uploaded');
    $bankNameMatch = $admin ? $profile->holderMatches($driver->name) : null;
@endphp

<link rel="stylesheet" href="{{ url('/admin/css/driver-documents.css') }}?v={{ $cssVer }}">

<div class="wrapper">
<div id="content">
<div class="dd" data-dd-root
     data-max-bytes="{{ config('driver_documents.max_size_kb') * 1024 }}"
     data-extensions="{{ implode(',', config('driver_documents.allowed_extensions')) }}"
     data-mimes="{{ implode(',', config('driver_documents.allowed_mimes')) }}">

    {{-- ───────── Page header ───────── --}}
    <header class="dd-page-head">
        @if($admin)
            <a class="dd-back" href="{{ route('admin.dv.index') }}">← All drivers</a>
            <h1>{{ $driver->name }}</h1>
            <p class="dd-sub">Driver &amp; vehicle documentation review</p>
            <ul class="dd-contact">
                <li><span>Email</span> {{ $driver->email }}</li>
                <li><span>Contact</span> {{ $driver->phone ?: '—' }}</li>
                <li><span>Account</span> {{ $driver->status == 1 ? 'Active' : 'Inactive' }}</li>
            </ul>
            <div class="dd-decision">
                <div class="dd-decision-state">
                    <span><span class="dd-overall-label">Application</span>
                        @if($application)
                            <span class="dd-pill dd-pill-{{ ['pending' => 'warning', 'approved' => 'success', 'declined' => 'danger'][$application] ?? 'muted' }}">{{ ucfirst($application) }}</span>
                        @else
                            <span class="dd-pill dd-pill-muted">Not an application</span>
                        @endif
                    </span>
                    <span><span class="dd-overall-label">Account</span>
                        <span class="dd-pill dd-pill-{{ $driver->status == 1 ? 'success' : 'muted' }}">{{ $driver->status == 1 ? 'Active' : 'Inactive' }}</span>
                    </span>
                </div>
                <div class="dd-actions">
                    @if($driver->status != 1)
                        <form method="POST" action="{{ route('admin.dv.application', $driver) }}"
                              data-dd-confirm="{{ $overall['status'] === 'verified' ? 'Activate this driver’s account? They will be able to log in and accept bookings.' : 'The documents are not fully verified yet (' . $overall['label'] . '). Activate this account anyway?' }}"
                              data-dd-confirm-title="Approve &amp; activate account?" data-dd-confirm-ok="Approve &amp; activate">
                            @csrf
                            <input type="hidden" name="action" value="approve">
                            @if($overall['status'] !== 'verified')<input type="hidden" name="force" value="1">@endif
                            <button type="submit" class="dd-btn dd-btn-success dd-btn-sm">Approve &amp; activate account</button>
                        </form>
                        @if($application === 'pending')
                            <form method="POST" action="{{ route('admin.dv.application', $driver) }}"
                                  data-dd-confirm="Decline this application? The driver will not be able to log in."
                                  data-dd-confirm-title="Decline application?" data-dd-confirm-ok="Decline" data-dd-confirm-danger>
                                @csrf
                                <input type="hidden" name="action" value="decline">
                                <button type="submit" class="dd-btn dd-btn-danger-outline dd-btn-sm">Decline application</button>
                            </form>
                        @endif
                    @else
                        <form method="POST" action="{{ route('admin.dv.application', $driver) }}"
                              data-dd-confirm="Deactivate this account? The driver will be logged out and can’t log in until re-activated."
                              data-dd-confirm-title="Deactivate account?" data-dd-confirm-ok="Deactivate" data-dd-confirm-danger>
                            @csrf
                            <input type="hidden" name="action" value="deactivate">
                            <button type="submit" class="dd-btn dd-btn-danger-outline dd-btn-sm">Deactivate account</button>
                        </form>
                    @endif
                </div>
            </div>
            @if($needsReview)
                <form method="POST" action="{{ $routes->startReview() }}" class="dd-inline-form">
                    @csrf
                    <button type="submit" class="dd-btn dd-btn-primary">Begin review</button>
                    <span class="dd-hint">Moves every newly uploaded document to “Under Review”.</span>
                </form>
            @endif
        @elseif($isApplicant)
            <h1>Complete your driver application</h1>
            <ol class="dd-steps" aria-label="Application steps">
                <li class="is-done"><span>✓</span> Account created</li>
                <li class="is-current"><span>2</span> Details &amp; documents</li>
                <li><span>3</span> Admin verification</li>
            </ol>
            <p class="dd-sub">Enter your details and upload each document below. An administrator will verify them and activate your account — you can log back in at any time to check progress or replace a document that needs attention.</p>
        @else
            <h1>Driver &amp; Vehicle Documentation</h1>
            <p class="dd-sub">Complete your details and upload each document. An administrator will review everything you submit.</p>
        @endif
    </header>

    @if(session('dd_success') && !$scrollTo)
        <div class="dd-flash" role="status">{{ session('dd_success') }}</div>
    @endif
    @if(session('error'))
        <div class="dd-flash dd-flash-error" role="alert">{{ session('error') }}</div>
    @endif

    {{-- ───────── Overall status ───────── --}}
    <div data-dd-summary>
        @include('driver-documents.partials.summary')
    </div>

    <nav class="dd-nav" aria-label="Sections">
        <a href="#dd-sec-details">Driver information</a>
        <a href="#dd-sec-licence">Licence</a>
        <a href="#dd-sec-bank">Bank</a>
        <a href="#dd-sec-vehicle">Vehicle</a>
        <a href="#dd-sec-vehicle-docs">Vehicle documents</a>
    </nav>

    {{-- ───────── 1. Driver information ───────── --}}
    <section class="dd-section" id="dd-sec-details" @if($scrollTo === 'details') data-dd-scroll @endif>
        <h2 class="dd-h">1. Driver information</h2>
        @if(session('dd_section') === 'details')<div class="dd-flash" role="status">{{ session('dd_success') }}</div>@endif
        <form method="POST" action="{{ $routes->details() }}" class="dd-form">
            @csrf
            <div class="dd-grid">
                @include('driver-documents.partials.field', ['bag' => 'details', 'name' => 'name', 'label' => 'Driver Name', 'value' => old('name', $driver->name), 'autocomplete' => 'name', 'maxlength' => 255])
                @include('driver-documents.partials.field', ['bag' => 'details', 'name' => 'email', 'label' => 'Email Address', 'inputType' => 'email', 'value' => old('email', $driver->email), 'autocomplete' => 'email', 'maxlength' => 255])
                @include('driver-documents.partials.field', ['bag' => 'details', 'name' => 'phone', 'label' => 'Contact Number', 'inputType' => 'tel', 'value' => old('phone', $driver->phone), 'autocomplete' => 'tel', 'inputmode' => 'tel', 'maxlength' => 20])
                @include('driver-documents.partials.field', ['bag' => 'details', 'name' => 'emergency_contact_name', 'label' => 'Emergency Contact Name', 'value' => old('emergency_contact_name', $profile->emergency_contact_name), 'maxlength' => 255])
                @include('driver-documents.partials.field', ['bag' => 'details', 'name' => 'emergency_contact_phone', 'label' => 'Emergency Contact Phone Number', 'inputType' => 'tel', 'value' => old('emergency_contact_phone', $profile->emergency_contact_phone), 'inputmode' => 'tel', 'maxlength' => 20])
            </div>
            <button type="submit" class="dd-btn dd-btn-primary">Save driver information</button>
        </form>
    </section>

    {{-- ───────── 2. Driver licence ───────── --}}
    <section class="dd-section" id="dd-sec-licence">
        <h2 class="dd-h">2. {{ config('driver_documents.groups.licence') }}</h2>
        <div class="dd-cards">
            @foreach($groups['licence'] as $type => $def)
                @include('driver-documents.partials.card', ['type' => $type, 'def' => $def, 'doc' => $docs->get($type)])
            @endforeach
        </div>
    </section>

    {{-- ───────── 3. Bank details ───────── --}}
    <section class="dd-section" id="dd-sec-bank" @if($scrollTo === 'bank') data-dd-scroll @endif>
        <h2 class="dd-h">3. {{ config('driver_documents.groups.bank') }}</h2>

        <p class="dd-secure">
            <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M12 1 3 5v6c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V5l-9-4zm-1 15-3.5-3.5 1.4-1.4L11 13.2l4.6-4.6L17 10l-6 6z"/></svg>
            <span>Bank details are encrypted when stored and are only ever shown masked. The <strong>name on the bank account must match the account holder name</strong> entered here.</span>
        </p>

        @if(session('dd_section') === 'bank')<div class="dd-flash" role="status">{{ session('dd_success') }}</div>@endif
        @if($admin && $bankNameMatch === false)
            <div class="dd-flash dd-flash-warn" role="alert">The account holder name doesn’t match the driver’s name. Check it against the bank statement before approving.</div>
        @elseif($admin && $bankNameMatch === true)
            <div class="dd-flash" role="status">Account holder name matches the driver’s name.</div>
        @endif

        <form method="POST" action="{{ $routes->bank() }}" class="dd-form" autocomplete="off">
            @csrf
            <div class="dd-grid">
                @include('driver-documents.partials.field', ['bag' => 'bank', 'name' => 'bank_account_holder', 'label' => 'Account Holder Name', 'value' => old('bank_account_holder', $profile->bank_account_holder), 'maxlength' => 120])
                @include('driver-documents.partials.field', ['bag' => 'bank', 'name' => 'bank_name', 'label' => 'Bank Name', 'value' => old('bank_name', $profile->bank_name), 'maxlength' => 100])
                @include('driver-documents.partials.field', [
                    'bag' => 'bank', 'name' => 'bank_account_number', 'label' => 'Account Number', 'value' => '',
                    'inputmode' => 'numeric', 'maxlength' => 12,
                    'required' => !filled($profile->bank_account_number),
                    'placeholder' => $profile->maskedAccountNumber() ?: '8-digit account number',
                    'hint' => $profile->maskedAccountNumber() ? 'Saved (' . $profile->maskedAccountNumber() . '). Leave blank to keep it.' : null,
                ])
                @include('driver-documents.partials.field', [
                    'bag' => 'bank', 'name' => 'bank_sort_code', 'label' => 'Sort Code', 'value' => '',
                    'inputmode' => 'numeric', 'maxlength' => 8,
                    'required' => !filled($profile->bank_sort_code),
                    'placeholder' => $profile->maskedSortCode() ?: '12-34-56',
                    'hint' => $profile->maskedSortCode() ? 'Saved (' . $profile->maskedSortCode() . '). Leave blank to keep it.' : null,
                ])
            </div>
            <button type="submit" class="dd-btn dd-btn-primary">Save bank details</button>
        </form>

        <div class="dd-cards dd-cards-single">
            @foreach($groups['bank'] as $type => $def)
                @include('driver-documents.partials.card', ['type' => $type, 'def' => $def, 'doc' => $docs->get($type)])
            @endforeach
        </div>
    </section>

    {{-- ───────── 4. Vehicle information ───────── --}}
    <section class="dd-section" id="dd-sec-vehicle" @if($scrollTo === 'vehicle') data-dd-scroll @endif>
        <h2 class="dd-h">4. Vehicle information</h2>
        @if(session('dd_section') === 'vehicle')<div class="dd-flash" role="status">{{ session('dd_success') }}</div>@endif
        <form method="POST" action="{{ $routes->vehicle() }}" class="dd-form">
            @csrf
            <div class="dd-grid dd-grid-3">
                @include('driver-documents.partials.field', ['bag' => 'vehicle', 'name' => 'make', 'label' => 'Make', 'value' => old('make', $driver->make), 'maxlength' => 100, 'placeholder' => 'e.g. Toyota'])
                @include('driver-documents.partials.field', ['bag' => 'vehicle', 'name' => 'model', 'label' => 'Model', 'value' => old('model', $driver->model), 'maxlength' => 100, 'placeholder' => 'e.g. Prius'])
                @include('driver-documents.partials.field', ['bag' => 'vehicle', 'name' => 'vehicle_year', 'label' => 'Year', 'inputType' => 'number', 'value' => old('vehicle_year', $profile->vehicle_year), 'inputmode' => 'numeric', 'min' => 1980, 'max' => now()->year + 1, 'placeholder' => (string) now()->year])
            </div>
            <button type="submit" class="dd-btn dd-btn-primary">Save vehicle information</button>
        </form>
    </section>

    {{-- ───────── 5. Vehicle documents ───────── --}}
    <section class="dd-section" id="dd-sec-vehicle-docs">
        <h2 class="dd-h">5. {{ config('driver_documents.groups.vehicle') }}</h2>
        <div class="dd-cards">
            @foreach($groups['vehicle'] as $type => $def)
                @include('driver-documents.partials.card', ['type' => $type, 'def' => $def, 'doc' => $docs->get($type)])
            @endforeach
        </div>
    </section>
</div>

{{-- ───────── Dialogs (native <dialog>: focus trap + Esc for free) ───────── --}}
<dialog class="dd-dialog dd-dialog-wide" id="ddPreview" aria-labelledby="ddPreviewTitle">
    <div class="dd-dialog-head">
        <h3 id="ddPreviewTitle">Preview</h3>
        <button type="button" class="dd-x" data-dd-close aria-label="Close preview">&times;</button>
    </div>
    <div class="dd-dialog-body" data-dd-preview-body></div>
    <div class="dd-dialog-foot">
        <a class="dd-btn dd-btn-outline dd-btn-sm" data-dd-download href="#">Download</a>
        <button type="button" class="dd-btn dd-btn-primary dd-btn-sm" data-dd-close>Close</button>
    </div>
</dialog>

<dialog class="dd-dialog" id="ddConfirm" aria-labelledby="ddConfirmTitle">
    <div class="dd-dialog-head">
        <h3 id="ddConfirmTitle"></h3>
        <button type="button" class="dd-x" data-dd-close aria-label="Cancel">&times;</button>
    </div>
    <div class="dd-dialog-body"><p data-dd-confirm-text></p></div>
    <div class="dd-dialog-foot">
        <button type="button" class="dd-btn dd-btn-outline dd-btn-sm" data-dd-close>Cancel</button>
        <button type="button" class="dd-btn dd-btn-primary dd-btn-sm" data-dd-confirm-ok>Confirm</button>
    </div>
</dialog>

<script src="{{ url('/admin/js/driver-documents.js') }}?v={{ $jsVer }}"></script>
</div>
</div>
