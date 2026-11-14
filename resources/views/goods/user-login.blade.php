<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>BN Taxi Anytime - Login</title>

        @include('goods.include.assets')

        @stylesheet('goods/css/pages/user-login.css')
    </head>

    <body>

        @include('goods.include.header')


        <!-- =====================================================
             LOGIN AREA
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
                                 HEADING
                                 =============================== -->

                            <h4 class="text-center mb-1">
                                Welcome Back
                            </h4>

                            <p class="text-center text-muted small mb-4">
                                Login to your account
                            </p>


                            <!-- ===============================
                                 SUCCESS MESSAGE
                                 =============================== -->

                            @if(session()->has('success'))

                                <div
                                    class="alert alert-success mb-3 alert-dismissible fade show"
                                    role="alert"
                                >

                                    {{ session()->get('success') }}

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
                                 LOGIN FORM
                                 =============================== -->

                            <form
                                method="POST"
                                action="{{ route('login') }}"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="type"
                                    value="0"
                                />


                                <!-- EMAIL -->

                                <div class="mb-3">

                                    <label class="form-label">
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        placeholder="Enter email"
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


                                <!-- FORGOT PASSWORD -->

                                <div class="d-flex justify-content-between align-items-center mb-3 small">

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
                                 REGISTER
                                 =============================== -->

                            <div class="text-center mt-3 small">

                                Don’t have an account?

                                <a href="{{ url('/user-register') }}">
                                    Register
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