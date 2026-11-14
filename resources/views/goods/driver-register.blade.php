<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BN Taxi Anytime - Driver Register</title>

    @include('goods.include.assets')

    @stylesheet('goods/css/pages/driver-register.css')
</head>

<body>

@include('goods.include.header')

<!-- =========================================================
     BANNER
     ========================================================= -->
<div class="driver-register-banner">
    <div class="driver-register-banner-content">
        <h1>Driver Register</h1>
        <h5>Home // <a href="">Driver Register</a></h5>
    </div>
</div>

<!-- =========================================================
     QUOTE STRIP
     ========================================================= -->
<div class="driver-register-quote">
    <div class="container">
        <h2>
            <span>Join our team of drivers</span>
            <span>Register</span>
        </h2>
    </div>
</div>

<!-- =========================================================
     REGISTER PAGE
     ========================================================= -->
<main class="main pages">

    <div class="driver-register-page">

        <div class="container">

            <div class="driver-register-card">

                <div class="driver-register-inner">

                    <!-- HEADER -->
                    <div class="driver-register-head">

                        <img
                            src="{{url('goods/images/logo.png')}}"
                            class="driver-register-logo img-fluid"
                            alt="BN Taxi Anytime"
                        >

                        <h1>Create a Driver Account</h1>

                        <ol class="driver-register-steps" aria-label="Registration steps">
                            <li class="is-current"><span>1</span> Your account</li>
                            <li><span>2</span> Upload documents</li>
                            <li><span>3</span> Admin verification</li>
                        </ol>

                        <p>
                            Already have an account?
                            <a href="{{url('/driver-login')}}">Login</a>
                        </p>

                    </div>


                    <!-- SUCCESS -->
                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        {{ session()->get('success') }}

                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif


                    <!-- ERROR -->
                    @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        {{ session()->get('error') }}

                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif


                    <!-- VALIDATION ERRORS -->
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Please fix the following:</strong>
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                    <!-- FORM -->
                    <form
                        method="POST"
                        action="{{url('/post-driver-register')}}"
                        class="driver-register-form"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="type"
                            value="2"
                        >

                        <div class="row">

                            <!-- FIRST NAME -->
                            <div class="col-md-6 form-group">
                                <label>First Name *</label>
                                <input
                                    type="text"
                                    name="first_name"
                                    value="{{ old('first_name') }}"
                                    class="form-control"
                                    placeholder="First Name"
                                    required=""
                                >
                            </div>

                            <!-- LAST NAME -->
                            <div class="col-md-6 form-group">
                                <label>Last Name *</label>
                                <input
                                    type="text"
                                    name="last_name"
                                    value="{{ old('last_name') }}"
                                    class="form-control"
                                    placeholder="Last Name"
                                    required=""
                                >
                            </div>

                            <!-- EMAIL -->
                            <div class="col-md-6 form-group">
                                <label>Email *</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control"
                                    placeholder="Email"
                                    required=""
                                >
                            </div>

                            <!-- PASSWORD -->
                            <div class="col-md-6 form-group">
                                <label>Password *</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Password (min. 8 characters)" minlength="8"
                                    required=""
                                >
                            </div>

                            <!-- PHONE -->
                            <div class="col-md-6 form-group">
                                <label>Phone *</label>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    class="form-control"
                                    placeholder="Phone"
                                    required=""
                                >
                            </div>

                            <!-- ADDRESS -->
                            <div class="col-md-6 form-group">
                                <label>Address *</label>
                                <input
                                    type="text"
                                    name="address"
                                    value="{{ old('address') }}"
                                    class="form-control"
                                    placeholder="Address"
                                    required=""
                                >
                            </div>

                            <!-- POST CODE -->
                            <div class="col-md-6 form-group">
                                <label>Post Code *</label>
                                <input
                                    type="text"
                                    name="postcode"
                                    value="{{ old('postcode') }}"
                                    class="form-control"
                                    placeholder="Post Code"
                                    required=""
                                >
                            </div>

                            <!-- VEHICLE REG NUMBER -->
                            <div class="col-md-6 form-group">
                                <label>Vehicle Reg Number *</label>
                                <input
                                    type="text"
                                    name="vehicleregnumber"
                                    value="{{ old('vehicleregnumber') }}"
                                    class="form-control"
                                    placeholder="Vehicle Reg Number"
                                    required=""
                                >
                            </div>

                            <!-- MAKE -->
                            <div class="col-md-6 form-group">
                                <label>Make *</label>
                                <input
                                    type="text"
                                    name="make"
                                    value="{{ old('make') }}"
                                    class="form-control"
                                    placeholder="Make"
                                    required=""
                                >
                            </div>

                            <!-- MODEL -->
                            <div class="col-md-6 form-group">
                                <label>Model *</label>
                                <input
                                    type="text"
                                    name="model"
                                    value="{{ old('model') }}"
                                    class="form-control"
                                    placeholder="Model"
                                    required=""
                                >
                            </div>

                            <!-- CAR TYPE -->
                            <div class="col-md-6 form-group">
                                <label for="">Car Type *</label>

                                <select
                                    name="cartype"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Select Car Type
                                    </option>

                                    @foreach($distnceprice ?? [] as $item)

                                        <option value="{{ $item->id }}" {{ (string) old('cartype') === (string) $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <!-- NEXT STEP -->
                            <div class="col-md-12">
                                <div class="driver-register-docs">
                                    <div class="driver-register-docs-title">
                                        Step 2: upload your documents
                                    </div>
                                    <p class="driver-register-next">
                                        As soon as you register you'll be taken to a secure page where you enter your
                                        emergency contact, bank and vehicle details and upload each document
                                        (PDF, JPG or PNG). An administrator verifies them and activates your account.
                                    </p>
                                    <ul class="driver-register-next-list">
                                        @foreach(config('driver_documents.types') as $doc)
                                            <li>{{ $doc['label'] }}@unless($doc['required']) <em>(optional)</em>@endunless</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>


                        <!-- TERMS -->
                        <div class="driver-register-terms login_footer form-group">

                            <div class="chek-form">

                                <div class="custome-checkbox">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="checkbox"
                                        id="exampleCheckbox12"
                                        required=""
                                    >

                                    <label
                                        class="form-check-label"
                                        for="exampleCheckbox12"
                                    >
                                        <span>
                                            I agree to terms &amp; Policy.
                                        </span>
                                    </label>

                                </div>

                            </div>

                        </div>


                        <!-- SUBMIT -->
                        <div
                            class="driver-register-submit form-group"
                            id="registers"
                        >

                            <button
                                type="submit"
                                class="btn btn-fill-out btn-block hover-up font-weight-bold"
                                name="login"
                            >
                                Submit &amp; Register
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>

@include('goods.include.footer')

<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"
></script>

</body>
</html>
