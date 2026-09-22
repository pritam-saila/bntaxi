<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BN Taxi Anytime - Driver Register</title>

    @include('goods.include.assets')

    <style>
        :root {
            --bn-dark: #061b45;
            --bn-navy: #082f7d;
            --bn-blue: #1557d6;
            --bn-blue-soft: #eaf3ff;
            --bn-border: #dce8f7;
            --bn-text: #18304f;
            --bn-muted: #718096;
        }

        /* =========================
           PAGE BACKGROUND
           ========================= */
        .driver-register-page {
            position: relative;
            overflow: hidden;
            padding: 65px 15px 75px;
            background:
                radial-gradient(circle at 5% 10%, rgba(21,87,214,.09), transparent 250px),
                radial-gradient(circle at 96% 90%, rgba(21,87,214,.09), transparent 280px),
                linear-gradient(135deg, #eaf3ff 0%, #ffffff 50%, #edf6ff 100%);
        }

        .driver-register-page::before {
            content: "";
            position: absolute;
            width: 460px;
            height: 460px;
            right: -285px;
            top: -250px;
            border: 65px solid rgba(21,87,214,.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .driver-register-page::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            left: -220px;
            bottom: -190px;
            border: 45px solid rgba(21,87,214,.045);
            border-radius: 50%;
            pointer-events: none;
        }

        .driver-register-page > .container {
            position: relative;
            z-index: 2;
        }

        /* =========================
           TOP BANNER
           ========================= */
        .driver-register-banner {
            position: relative;
            overflow: hidden;
            min-height: 185px;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #04183f 0%, #082f7d 52%, #1557d6 100%);
            box-shadow: 0 12px 35px rgba(6,36,95,.16);
        }

        .driver-register-banner::before {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            right: -190px;
            top: -220px;
            border: 52px solid rgba(255,255,255,.05);
            border-radius: 50%;
        }

        .driver-register-banner-content {
            position: relative;
            z-index: 2;
            max-width: 1180px;
            width: 100%;
            margin: 0 auto;
            padding: 35px 20px;
        }

        .driver-register-banner-content h1 {
            margin: 0 0 9px;
            color: #fff;
            font-size: 36px;
            line-height: 1.15;
            font-weight: 850;
        }

        .driver-register-banner-content h5 {
            margin: 0;
            color: rgba(255,255,255,.72);
            font-size: 12px;
            font-weight: 600;
        }

        .driver-register-banner-content h5 a {
            color: #9fc9ff;
            text-decoration: none;
            font-weight: 750;
        }

        /* =========================
           QUOTE STRIP
           ========================= */
        .driver-register-quote {
            background: #fff;
            border-bottom: 1px solid var(--bn-border);
            box-shadow: 0 5px 18px rgba(8,47,125,.05);
        }

        .driver-register-quote .container {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .driver-register-quote h2 {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            color: var(--bn-text);
            font-size: 14px;
            font-weight: 750;
        }

        .driver-register-quote h2 span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            padding: 7px 17px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--bn-blue), var(--bn-navy));
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            box-shadow: 0 7px 18px rgba(21,87,214,.22);
        }

        /* =========================
           REGISTER CARD
           ========================= */
        .driver-register-card {
            position: relative;
            overflow: hidden;
            max-width: 1080px;
            margin: 0 auto;
            border-radius: 25px;
            background: #fff;
            border: 1px solid rgba(21,87,214,.13);
            box-shadow:
                0 28px 70px rgba(6,36,95,.15),
                0 6px 20px rgba(6,36,95,.05);
        }

        .driver-register-card::before {
            content: "";
            display: block;
            width: 100%;
            height: 7px;
            background: linear-gradient(90deg, #061b45, #1557d6, #061b45);
        }

        .driver-register-card::after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            right: -175px;
            top: -150px;
            border: 36px solid rgba(21,87,214,.045);
            border-radius: 50%;
            pointer-events: none;
        }

        .driver-register-inner {
            position: relative;
            z-index: 2;
            padding: 38px 44px 36px;
        }

        /* =========================
           HEADER
           ========================= */
        .driver-register-head {
            text-align: center;
            padding-bottom: 24px;
            margin-bottom: 26px;
            border-bottom: 1px solid #edf2f8;
        }

        .driver-register-logo {
            width: 145px;
            max-width: 100%;
            height: auto;
            object-fit: contain;
            margin-bottom: 16px;
        }

        .driver-register-head h1 {
            position: relative;
            margin: 0 0 9px;
            padding-bottom: 13px;
            color: var(--bn-dark);
            font-size: 29px;
            line-height: 1.2;
            font-weight: 850;
        }

        .driver-register-head h1::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 55px;
            height: 4px;
            border-radius: 20px;
            background: linear-gradient(90deg, var(--bn-navy), var(--bn-blue));
        }

        .driver-register-head p {
            margin: 15px 0 0;
            color: var(--bn-muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .driver-register-head p a {
            color: var(--bn-blue);
            font-weight: 800;
            text-decoration: none;
        }

        /* =========================
           ALERTS
           ========================= */
        .driver-register-card .alert {
            position: relative;
            padding: 12px 42px 12px 15px !important;
            margin-bottom: 22px !important;
            border-radius: 10px !important;
            font-size: 12px;
            line-height: 1.55;
            font-weight: 600;
        }

        .driver-register-card .alert-success {
            color: #155724;
            background: #edf9f1;
            border: 1px solid #ccebd6;
        }

        .driver-register-card .alert-danger {
            color: #842029;
            background: #fff2f3;
            border: 1px solid #f2c6cb;
        }

        .driver-register-card .alert ul {
            padding-left: 17px;
            margin: 0;
        }

        .driver-register-card .alert .close {
            position: absolute;
            right: 9px;
            top: 7px;
            color: inherit;
            opacity: .7;
        }

        /* =========================
           FORM
           ========================= */
        .driver-register-form {
            position: relative;
            z-index: 3;
        }

        .driver-register-form .form-group {
            margin-bottom: 17px;
        }

        .driver-register-form label {
            display: block;
            margin-bottom: 7px;
            color: #263d5d;
            font-size: 12px;
            line-height: 1.4;
            font-weight: 800;
        }

        .driver-register-form .form-control {
            width: 100%;
            min-height: 51px;
            padding: 11px 14px;
            box-sizing: border-box;
            border: 1px solid var(--bn-border) !important;
            border-radius: 10px !important;
            background: #f9fbff !important;
            color: var(--bn-text) !important;
            font-size: 13px !important;
            font-weight: 550;
            outline: none;
            box-shadow: inset 0 1px 2px rgba(8,47,125,.025);
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .driver-register-form input.form-control {
            height: 51px;
        }

        .driver-register-form select.form-control {
            height: 51px;
            cursor: pointer;
        }

        .driver-register-form textarea.form-control {
            min-height: 100px;
            resize: vertical;
            line-height: 1.6;
        }

        .driver-register-form input[type="file"].form-control {
            padding: 12px 13px;
            background: #f7faff !important;
            cursor: pointer;
        }

        .driver-register-form .form-control::placeholder {
            color: #8b98aa;
            opacity: 1;
        }

        .driver-register-form .form-control:focus {
            border-color: var(--bn-blue) !important;
            background: #fff !important;
            box-shadow: 0 0 0 3px rgba(21,87,214,.09) !important;
        }

        /* =========================
           DOCUMENT SECTION
           ========================= */
        .driver-register-steps { list-style: none; display: flex; justify-content: center; flex-wrap: wrap; gap: 8px 22px; padding: 0; margin: 14px 0 0; font-size: 14px; color: var(--bn-muted); }
        .driver-register-steps li { display: flex; align-items: center; gap: 8px; }
        .driver-register-steps li span { width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: var(--bn-blue-soft); color: var(--bn-blue); font-weight: 700; font-size: 13px; }
        .driver-register-steps li.is-current { color: var(--bn-text); font-weight: 600; }
        .driver-register-steps li.is-current span { background: var(--bn-blue); color: #fff; }
        .driver-register-next { color: var(--bn-text); font-size: 14px; margin-bottom: 10px; }
        .driver-register-next-list { margin: 0; padding-left: 20px; columns: 2; column-gap: 28px; font-size: 14px; color: var(--bn-text); }
        .driver-register-next-list li { break-inside: avoid; margin-bottom: 4px; }
        @media (max-width: 600px) { .driver-register-next-list { columns: 1; } }

        .driver-register-docs {
            margin-top: 5px;
            padding: 20px;
            border: 1px solid #e1ebf7;
            border-radius: 15px;
            background: linear-gradient(145deg, #f8fbff, #eef6ff);
        }

        .driver-register-docs-title {
            margin: 0 0 15px;
            color: var(--bn-navy);
            font-size: 13px;
            font-weight: 850;
        }

        /* =========================
           TERMS
           ========================= */
        .driver-register-terms {
            margin-top: 8px;
            margin-bottom: 22px;
            padding: 14px 16px;
            border: 1px solid #e2ebf6;
            border-radius: 10px;
            background: #f9fbff;
        }

        .driver-register-terms .custome-checkbox {
            display: flex;
            align-items: center;
        }

        .driver-register-terms .form-check-input {
            width: 16px;
            height: 16px;
            margin: 0 8px 0 0;
            accent-color: var(--bn-blue);
            cursor: pointer;
        }

        .driver-register-terms .form-check-label {
            margin: 0;
            color: #52647b;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        /* =========================
           SUBMIT
           ========================= */
        .driver-register-submit {
            margin-bottom: 5px !important;
        }

        .driver-register-submit button {
            width: 100%;
            min-height: 53px;
            border: 0 !important;
            border-radius: 10px !important;
            background: linear-gradient(135deg, #1557d6 0%, #0b3d9e 100%) !important;
            color: #fff !important;
            font-size: 13px !important;
            font-weight: 850 !important;
            letter-spacing: .2px;
            box-shadow: 0 12px 27px rgba(21,87,214,.24);
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .driver-register-submit button:hover {
            background: linear-gradient(135deg, #0b3d9e, #061b45) !important;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(8,47,125,.27);
        }

        .driver-register-submit button:active {
            transform: translateY(0);
        }

        /* =========================
           TABLET
           ========================= */
        @media (max-width: 767px) {
            .driver-register-page {
                padding: 45px 10px 55px;
            }

            .driver-register-banner {
                min-height: 150px;
            }

            .driver-register-banner-content {
                padding: 30px 18px;
            }

            .driver-register-banner-content h1 {
                font-size: 30px;
            }

            .driver-register-quote .container {
                padding-top: 12px;
                padding-bottom: 12px;
            }

            .driver-register-quote h2 {
                font-size: 12px;
            }

            .driver-register-card {
                border-radius: 20px;
            }

            .driver-register-inner {
                padding: 30px 24px 30px;
            }

            .driver-register-logo {
                width: 135px;
            }

            .driver-register-head h1 {
                font-size: 25px;
            }

            .driver-register-form label {
                font-size: 12px;
            }

            /* Mobile form controls = 14px */
            .driver-register-form .form-control {
                font-size: 14px !important;
            }

            .driver-register-form input.form-control,
            .driver-register-form select.form-control {
                height: 51px;
            }

            .driver-register-form textarea.form-control {
                min-height: 100px;
            }

            .driver-register-submit button {
                min-height: 51px;
                font-size: 14px !important;
            }
        }

        /* =========================
           SMALL MOBILE
           ========================= */
        @media (max-width: 480px) {
            .driver-register-page {
                padding: 35px 7px 45px;
            }

            .driver-register-banner {
                min-height: 135px;
            }

            .driver-register-banner-content {
                padding: 25px 15px;
            }

            .driver-register-banner-content h1 {
                font-size: 27px;
            }

            .driver-register-banner-content h5 {
                font-size: 11px;
            }

            .driver-register-quote h2 {
                display: block;
                font-size: 11px;
                line-height: 1.5;
            }

            .driver-register-quote h2 span {
                margin-top: 7px;
                min-height: 34px;
                padding: 6px 13px;
                font-size: 10px;
            }

            .driver-register-inner {
                padding: 27px 17px 28px;
            }

            .driver-register-logo {
                width: 125px;
            }

            .driver-register-head h1 {
                font-size: 23px;
            }

            .driver-register-head p {
                font-size: 11px;
            }

            .driver-register-form .form-control {
                font-size: 14px !important;
            }

            .driver-register-form input.form-control,
            .driver-register-form select.form-control {
                height: 50px;
            }

            .driver-register-form textarea.form-control {
                min-height: 95px;
            }

            .driver-register-docs {
                padding: 15px;
            }

            .driver-register-terms .form-check-label {
                font-size: 11px;
            }

            .driver-register-submit button {
                min-height: 49px;
                font-size: 14px !important;
            }
        }
    </style>
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
