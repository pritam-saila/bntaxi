@include('admin.include.sidebar')

@php $cssVer = @filemtime(public_path('admin/css/driver-documents.css')) ?: 1; @endphp
<link rel="stylesheet" href="{{ url('/admin/css/driver-documents.css') }}?v={{ $cssVer }}">

<div class="wrapper">
<div id="content">
<div class="dd">

    <header class="dd-page-head">
        <h1>My Account</h1>
        <p class="dd-sub">Keep your contact, business and vehicle details up to date.</p>
    </header>

    @if(session('success') || session('dd_success'))
        <div class="dd-flash" role="status">{{ session('success') ?? session('dd_success') }}</div>
    @endif
    @if(session('error'))
        <div class="dd-flash dd-flash-error" role="alert">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="dd-flash dd-flash-error" role="alert">Please fix the highlighted fields and save again.</div>
    @endif

    {{-- Verification at a glance - replaces the old free-text insurance boxes --}}
    <section class="dd-summary dd-tone-{{ $overall['tone'] }}">
        <div class="dd-summary-head">
            <div>
                <h2 class="dd-h">Documents &amp; verification</h2>
                <p class="dd-sub">{{ $overall['summary'] }}</p>
            </div>
            <div class="dd-overall">
                <span class="dd-overall-label">Overall Status</span>
                <span class="dd-pill dd-pill-{{ $overall['tone'] }}">{{ $overall['label'] }}</span>
            </div>
        </div>
        <div class="dd-meter" role="progressbar" aria-valuenow="{{ $overall['required_total'] ? (int) round($overall['approved'] / $overall['required_total'] * 100) : 0 }}" aria-valuemin="0" aria-valuemax="100" aria-label="Required documents approved">
            <span style="width: {{ $overall['required_total'] ? (int) round($overall['approved'] / $overall['required_total'] * 100) : 0 }}%"></span>
        </div>
        <p class="dd-meter-text">
            {{ $overall['approved'] }} of {{ $overall['required_total'] }} required documents approved
            @if($overall['expiring'])
                · <strong class="dd-warn-text">{{ $overall['expiring'] }} {{ $overall['expiring'] === 1 ? 'document is' : 'documents are' }} expired or expiring soon</strong>
            @endif
        </p>
        <div class="dd-actions dd-actions-start">
            <a class="dd-btn dd-btn-primary dd-btn-sm" href="{{ route('driver.docs.index') }}">Manage documents</a>
        </div>
    </section>

    <form method="POST" action="{{ url('driver-update') }}" novalidate>
        @csrf

        <section class="dd-section">
            <h2 class="dd-h">Personal details</h2>
            <div class="dd-grid">
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'name', 'label' => 'Full Name', 'value' => old('name', $data->name), 'autocomplete' => 'name', 'maxlength' => 255])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'email', 'label' => 'Email Address', 'inputType' => 'email', 'value' => old('email', $data->email), 'autocomplete' => 'email', 'maxlength' => 255])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'phone', 'label' => 'Contact Number', 'inputType' => 'tel', 'value' => old('phone', $data->phone), 'autocomplete' => 'tel', 'inputmode' => 'tel', 'maxlength' => 20])
                <div class="dd-field">
                    <label>Account status</label>
                    <p class="dd-static">
                        <span class="dd-pill dd-pill-{{ $data->status == 1 ? 'success' : 'muted' }}">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</span>
                    </p>
                    <p class="dd-hint">Your status is managed by the BN Taxi team.</p>
                </div>
            </div>
        </section>

        <section class="dd-section">
            <h2 class="dd-h">Business details</h2>
            <div class="dd-grid">
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'company_name', 'label' => 'Company Name', 'required' => false, 'value' => old('company_name', $data->company_name), 'maxlength' => 255])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'address', 'label' => 'Address', 'value' => old('address', $data->address), 'autocomplete' => 'street-address', 'maxlength' => 500])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'vatnumber', 'label' => 'VAT Number', 'required' => false, 'value' => old('vatnumber', $data->vatnumber), 'maxlength' => 50])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'companyregnumber', 'label' => 'Company Registration Number', 'required' => false, 'value' => old('companyregnumber', $data->companyregnumber), 'maxlength' => 50])
            </div>
        </section>

        <section class="dd-section">
            <h2 class="dd-h">Vehicle</h2>
            <div class="dd-grid dd-grid-3">
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'vehicleregnumber', 'label' => 'Registration Number', 'value' => old('vehicleregnumber', $data->vehicleregnumber), 'maxlength' => 20])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'make', 'label' => 'Make', 'value' => old('make', $data->make), 'maxlength' => 100])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'model', 'label' => 'Model', 'value' => old('model', $data->model), 'maxlength' => 100])
            </div>
            <p class="dd-hint">Vehicle year and your licence, insurance and V5C documents live under <a href="{{ route('driver.docs.index') }}">My Documents</a>.</p>
        </section>

        <div class="dd-form-actions">
            <button type="submit" class="dd-btn dd-btn-primary">Save changes</button>
            <a class="dd-btn dd-btn-outline" href="{{ route('driverchangepass') }}">Change password</a>
        </div>
    </form>
</div>
</div>
</div>
