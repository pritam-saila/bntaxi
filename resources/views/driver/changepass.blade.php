@include('admin.include.sidebar')

@php $cssVer = @filemtime(public_path('admin/css/driver-documents.css')) ?: 1; @endphp
<link rel="stylesheet" href="{{ url('/admin/css/driver-documents.css') }}?v={{ $cssVer }}">

<div class="wrapper">
<div id="content">
<div class="dd">

    <header class="dd-page-head">
        <a class="dd-back" href="{{ route('driveraccount') }}">← My Account</a>
        <h1>Change Password</h1>
        <p class="dd-sub">Choose a strong password you don’t use anywhere else.</p>
    </header>

    @if(session('success') || session('dd_success'))
        <div class="dd-flash" role="status">{{ session('success') ?? session('dd_success') }}</div>
    @endif
    @if(session('error'))
        <div class="dd-flash dd-flash-error" role="alert">{{ session('error') }}</div>
    @endif

    <section class="dd-section dd-section-narrow">
        <form method="POST" action="{{ route('driverchangepassword.update') }}" novalidate>
            @csrf
            <div class="dd-stack">
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'current_password', 'label' => 'Current Password', 'inputType' => 'password', 'value' => '', 'autocomplete' => 'current-password'])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'password', 'label' => 'New Password', 'inputType' => 'password', 'value' => '', 'autocomplete' => 'new-password', 'hint' => 'At least 8 characters.', 'minlength' => 8])
                @include('driver-documents.partials.field', ['bag' => 'default', 'name' => 'password_confirmation', 'label' => 'Confirm New Password', 'inputType' => 'password', 'value' => '', 'autocomplete' => 'new-password'])
            </div>
            <div class="dd-form-actions">
                <button type="submit" class="dd-btn dd-btn-primary">Update password</button>
            </div>
        </form>
    </section>
</div>
</div>
</div>
