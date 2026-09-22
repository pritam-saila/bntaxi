<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Driver Login | BN Taxi Anytime</title>

        @include('goods.include.assets')

        <style>
            /* =========================================================
               BN TAXI - DRIVER LOGIN
               PREMIUM ROYAL BLUE + WHITE THEME
               Dynamic Laravel functionality preserved
               ========================================================= */

            :root {
                --driver-dark: #061b45;
                --driver-navy: #082f7d;
                --driver-blue: #1557d6;
                --driver-blue-light: #eaf3ff;
                --driver-border: #dce8f7;
                --driver-text: #142b4d;
                --driver-muted: #718096;
            }

            /* =====================================================
               MAIN BACKGROUND
               ===================================================== */

            .bntaxi-login-wrapper {
                position: relative;
                overflow: hidden;

                min-height: 650px;

                display: flex;
                align-items: center;

                padding: 65px 15px;

                background:
                    radial-gradient(
                        circle at 8% 15%,
                        rgba(21, 87, 214, 0.11),
                        transparent 250px
                    ),
                    radial-gradient(
                        circle at 94% 82%,
                        rgba(21, 87, 214, 0.09),
                        transparent 280px
                    ),
                    linear-gradient(
                        135deg,
                        #eaf3ff 0%,
                        #ffffff 48%,
                        #eaf3ff 100%
                    );
            }

            /* Decorative background circles */

            .bntaxi-login-wrapper::before {
                content: "";

                position: absolute;

                width: 450px;
                height: 450px;

                right: -270px;
                top: -255px;

                border:
                    65px solid
                    rgba(21, 87, 214, 0.055);

                border-radius: 50%;

                pointer-events: none;
            }

            .bntaxi-login-wrapper::after {
                content: "";

                position: absolute;

                width: 310px;
                height: 310px;

                left: -220px;
                bottom: -200px;

                border:
                    45px solid
                    rgba(21, 87, 214, 0.045);

                border-radius: 50%;

                pointer-events: none;
            }

            .bntaxi-login-wrapper > .container {
                position: relative;
                z-index: 2;
            }

            /* =====================================================
               DRIVER LOGIN CARD
               ===================================================== */

            .bntaxi-login-card {
                position: relative;

                overflow: hidden;

                padding: 38px 40px 35px;

                border-radius: 24px;

                background:
                    linear-gradient(
                        145deg,
                        #ffffff 0%,
                        #ffffff 72%,
                        #f1f7ff 100%
                    );

                border:
                    1px solid
                    rgba(21, 87, 214, 0.14);

                box-shadow:
                    0 28px 65px
                    rgba(6, 36, 95, 0.17),
                    0 7px 20px
                    rgba(6, 36, 95, 0.06);
            }

            /* Premium blue top bar */

            .bntaxi-login-card::before {
                content: "";

                position: absolute;

                top: 0;
                left: 0;

                width: 100%;
                height: 6px;

                background:
                    linear-gradient(
                        90deg,
                        var(--driver-dark),
                        var(--driver-blue),
                        var(--driver-dark)
                    );
            }

            /* Decorative card circle */

            .bntaxi-login-card::after {
                content: "";

                position: absolute;

                width: 220px;
                height: 220px;

                right: -145px;
                top: -120px;

                border:
                    31px solid
                    rgba(21, 87, 214, 0.05);

                border-radius: 50%;

                pointer-events: none;
            }

            /* =====================================================
               LOGO
               ===================================================== */

            .bntaxi-login-card .text-center:first-child {
                position: relative;
                z-index: 3;

                margin-bottom: 20px !important;

                padding-bottom: 17px;

                border-bottom:
                    1px solid #edf2f8;
            }

            .bntaxi-logo {
                width: 145px;

                max-width: 100%;
                height: auto;

                object-fit: contain;
            }

            /* =====================================================
               DRIVER TITLE
               ===================================================== */

            .bntaxi-login-card h4 {
                position: relative;
                z-index: 3;

                margin: 0 0 7px;

                color:
                    var(--driver-dark);

                font-size: 26px;

                line-height: 1.2;

                font-weight: 850;
            }

            .bntaxi-login-card h4::after {
                content: "";

                display: block;

                width: 45px;
                height: 3px;

                margin: 12px auto 0;

                border-radius: 20px;

                background:
                    linear-gradient(
                        90deg,
                        var(--driver-navy),
                        var(--driver-blue)
                    );
            }

            .bntaxi-login-card > .text-center.text-muted {
                position: relative;
                z-index: 3;

                margin-top: 10px !important;

                color:
                    var(--driver-muted) !important;

                font-size: 12px !important;

                font-weight: 500;
            }

            /* =====================================================
               ERROR ALERT
               ===================================================== */

            .bntaxi-login-card .alert {
                position: relative;
                z-index: 5;

                margin-bottom: 20px !important;

                padding:
                    12px 40px 12px 14px !important;

                border-radius: 10px !important;

                font-size: 12px;

                line-height: 1.5;

                font-weight: 600;
            }

            .bntaxi-login-card .alert-danger {
                color: #842029;

                background:
                    #fff2f3;

                border:
                    1px solid #f2c6cb;
            }

            .bntaxi-login-card .alert .close {
                position: absolute;

                top: 7px;
                right: 9px;

                color: inherit;

                opacity: .7;
            }

            /* =====================================================
               FORM
               ===================================================== */

            .bntaxi-login-card form {
                position: relative;
                z-index: 4;
            }

            .bntaxi-login-card .mb-3 {
                margin-bottom: 18px !important;
            }

            .bntaxi-login-card .mb-2 {
                margin-bottom: 10px !important;
            }

            /* =====================================================
               LABEL
               ===================================================== */

            .bntaxi-login-card .form-label {
                display: block;

                margin-bottom: 7px;

                color:
                    #263d5d;

                font-size: 12px;

                line-height: 1.4;

                font-weight: 800;
            }

            /* =====================================================
               INPUT
               ===================================================== */

            .bntaxi-login-card .form-control {
                width: 100%;

                height: 52px;

                padding:
                    0 14px;

                box-sizing: border-box;

                border:
                    1px solid
                    var(--driver-border) !important;

                border-radius: 10px !important;

                background:
                    #f9fbff !important;

                color:
                    var(--driver-text) !important;

                font-size: 13px !important;

                font-weight: 550;

                outline: none;

                box-shadow:
                    inset 0 1px 2px
                    rgba(8, 47, 125, 0.025);

                transition:
                    border-color .2s ease,
                    background .2s ease,
                    box-shadow .2s ease;
            }

            .bntaxi-login-card .form-control::placeholder {
                color:
                    #8b98aa;

                opacity: 1;
            }

            .bntaxi-login-card .form-control:focus {
                border-color:
                    var(--driver-blue) !important;

                background:
                    #ffffff !important;

                box-shadow:
                    0 0 0 3px
                    rgba(21, 87, 214, 0.09) !important;
            }

            /* =====================================================
               OPTIONS
               ===================================================== */

            .bntaxi-login-card form > .d-flex {
                margin-bottom: 21px !important;

                color:
                    #64758c;

                font-size: 11px;
            }

            /* Remember checkbox */

            .bntaxi-login-card form > .d-flex > div {
                display: flex;

                align-items: center;

                gap: 7px;

                color:
                    #64758c;

                font-size: 11px;

                font-weight: 600;
            }

            .bntaxi-login-card form > .d-flex input[type="checkbox"] {
                width: 15px;
                height: 15px;

                margin: 0;

                accent-color:
                    var(--driver-blue);

                cursor: pointer;
            }

            /* Forgot password */

            .bntaxi-login-card form > .d-flex a {
                color:
                    #64758c;

                font-size: 11px;

                font-weight: 650;

                text-decoration: none;
            }

            .bntaxi-login-card form > .d-flex a:hover {
                color:
                    var(--driver-blue);

                text-decoration: underline;
            }

            /* =====================================================
               LOGIN BUTTON
               ===================================================== */

            .bntaxi-login-card .btn-primary {
                position: relative;

                width: 100%;

                min-height: 52px;

                border: 0 !important;

                border-radius: 10px !important;

                background:
                    linear-gradient(
                        135deg,
                        #1557d6 0%,
                        #0b3d9e 100%
                    ) !important;

                color:
                    #ffffff !important;

                font-size: 13px !important;

                font-weight: 850 !important;

                letter-spacing: .2px;

                box-shadow:
                    0 12px 26px
                    rgba(21, 87, 214, 0.25);

                transition:
                    transform .2s ease,
                    box-shadow .2s ease,
                    background .2s ease;
            }

            .bntaxi-login-card .btn-primary:hover {
                background:
                    linear-gradient(
                        135deg,
                        #0b3d9e,
                        #06245f
                    ) !important;

                color:
                    #ffffff !important;

                transform:
                    translateY(-2px);

                box-shadow:
                    0 16px 32px
                    rgba(8, 47, 125, 0.28);
            }

            .bntaxi-login-card .btn-primary:active {
                transform:
                    translateY(0);
            }

            /* =====================================================
               DRIVER REGISTER FOOTER
               ===================================================== */

            .bntaxi-login-card > .text-center.mt-3 {
                position: relative;
                z-index: 3;

                margin-top: 21px !important;

                padding-top: 18px;

                border-top:
                    1px solid #edf2f8;

                color:
                    #718096;

                font-size: 12px !important;

                line-height: 1.6;
            }

            .bntaxi-login-card > .text-center.mt-3 a {
                color:
                    var(--driver-blue);

                font-weight: 800;

                text-decoration: none;
            }

            .bntaxi-login-card > .text-center.mt-3 a:hover {
                color:
                    var(--driver-dark);

                text-decoration: underline;
            }

            /* =====================================================
               TABLET
               ===================================================== */

            @media (max-width: 767px) {

                .bntaxi-login-wrapper {
                    min-height: 590px;

                    padding:
                        48px 12px;
                }

                .bntaxi-login-card {
                    padding:
                        31px 25px 30px;

                    border-radius: 20px;
                }

                .bntaxi-logo {
                    width: 135px;
                }

                .bntaxi-login-card h4 {
                    font-size: 24px;
                }

                .bntaxi-login-card .form-label {
                    font-size: 12px;
                }

                /* Mobile input font 14px */

                .bntaxi-login-card .form-control {
                    height: 51px;

                    font-size: 14px !important;
                }

                .bntaxi-login-card form > .d-flex {
                    font-size: 12px;
                }

                .bntaxi-login-card form > .d-flex > div {
                    font-size: 12px;
                }

                .bntaxi-login-card form > .d-flex a {
                    font-size: 12px;
                }

                .bntaxi-login-card .btn-primary {
                    min-height: 51px;

                    font-size: 14px !important;
                }
            }

            /* =====================================================
               SMALL MOBILE
               ===================================================== */

            @media (max-width: 480px) {

                .bntaxi-login-wrapper {
                    min-height: 560px;

                    padding:
                        35px 8px;
                }

                .bntaxi-login-card {
                    padding:
                        27px 17px 28px;

                    border-radius: 18px;
                }

                .bntaxi-logo {
                    width: 125px;
                }

                .bntaxi-login-card h4 {
                    font-size: 22px;
                }

                .bntaxi-login-card > .text-center.text-muted {
                    font-size: 11px !important;
                }

                .bntaxi-login-card .form-label {
                    font-size: 12px;
                }

                /* Mobile form = 14px */

                .bntaxi-login-card .form-control {
                    height: 50px;

                    padding:
                        0 13px;

                    font-size: 14px !important;
                }

                .bntaxi-login-card form > .d-flex {
                    margin-bottom: 19px !important;
                }

                .bntaxi-login-card form > .d-flex > div {
                    font-size: 11px;
                }

                .bntaxi-login-card form > .d-flex a {
                    font-size: 11px;
                }

                .bntaxi-login-card .btn-primary {
                    min-height: 49px;

                    font-size: 14px !important;
                }

                .bntaxi-login-card > .text-center.mt-3 {
                    font-size: 12px !important;
                }
            }
        </style>
    </head>

    <body>

        @include('goods.include.header')


        <!-- =====================================================
             DRIVER LOGIN
             ===================================================== -->

        <div class="bntaxi-login-wrapper">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-md-5 col-lg-5">

                        <div class="bntaxi-login-card">


                            <!-- ===============================
                                 LOGO
                                 =============================== -->

                            <div class="text-center mb-3">

                                <img
                                    src="{{url('goods/images/logo.png')}}"
                                    class="bntaxi-logo img-fluid"
                                    alt="BN Taxi Anytime"
                                />

                            </div>


                            <!-- ===============================
                                 DRIVER TITLE
                                 =============================== -->

                            <h4 class="text-center mb-1">
                                Driver Login
                            </h4>

                            <p class="text-center text-muted small mb-4">
                                Access your driver dashboard
                            </p>


                            <!-- ===============================
                                 ERROR MESSAGE
                                 =============================== -->

                            @if(session()->has('error'))

                                <div
                                    class="alert alert-danger mb-3 alert-dismissible fade show"
                                    role="alert"
                                >

                                    {{ session()->get('error') }}

                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="alert"
                                        aria-label="Close"
                                    >

                                        <span aria-hidden="true">
                                            &times;
                                        </span>

                                    </button>

                                </div>

                            @endif


                            <!-- ===============================
                                 DRIVER LOGIN FORM
                                 =============================== -->

                            <form
                                method="POST"
                                action="{{ route('login') }}"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="type"
                                    value="2"
                                />


                                <!-- DRIVER ID / EMAIL -->

                                <div class="mb-3">

                                    <label class="form-label">
                                        Driver ID / Email
                                    </label>

                                    <input
                                        type="text"
                                        name="email"
                                        class="form-control"
                                        placeholder="Enter driver ID or email"
                                        required
                                    />

                                </div>


                                <!-- PASSWORD -->

                                <div class="mb-2">

                                    <label class="form-label">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Enter password"
                                        required
                                    />

                                </div>


                                <!-- OPTIONS -->

                                <div class="d-flex justify-content-between align-items-center mb-3 small">

                                    <div>

                                        <input
                                            type="checkbox"
                                        />

                                        <span>
                                            Remember me
                                        </span>

                                    </div>


                                    <a href="#">
                                        Forgot Password?
                                    </a>

                                </div>


                                <!-- LOGIN BUTTON -->

                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                >
                                    Login
                                </button>

                            </form>


                            <!-- ===============================
                                 DRIVER REGISTER
                                 =============================== -->

                            <div class="text-center mt-3 small">

                                Not a driver?

                                <a href="{{ url('/driver-register') }}">
                                    Driver Register
                                </a>

                            </div>


                        </div>

                    </div>

                </div>

            </div>

        </div>


        @include('goods.include.footer')

    </body>
</html>