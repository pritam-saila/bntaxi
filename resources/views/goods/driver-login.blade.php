<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Driver Login | BN Taxi Anytime</title>

        @include('goods.include.assets')

        @stylesheet('goods/css/pages/driver-login.css')
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