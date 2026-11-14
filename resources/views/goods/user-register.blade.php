<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>User Register | BN Taxi Anytime</title>

        @include('goods.include.assets')

        @stylesheet('goods/css/pages/user-register.css')
    </head>

    <body>

        @include('goods.include.header')


        <!-- =====================================================
             REGISTER AREA
             ===================================================== -->

        <div class="bntaxi-login-wrapper">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-md-8 col-lg-8">

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
                                Create an Account
                            </h4>

                            <p class="text-center text-muted small mb-4">
                                Register your account
                            </p>


                            <!-- ===============================
                                 VALIDATION ERRORS
                                 =============================== -->

                            @if($errors->any())

                                <div
                                    class="alert alert-danger mb-3 alert-dismissible fade show"
                                    role="alert"
                                >

                                    <ul class="mb-0">

                                        @foreach($errors->all() as $error)

                                            <li>
                                                {{ $error }}
                                            </li>

                                        @endforeach

                                    </ul>


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
                                 REGISTER FORM
                                 =============================== -->

                            <form
                                method="POST"
                                action="{{url('/postregister')}}"
                            >

                                @csrf


                                <div class="row">


                                    <!-- NAME -->

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Name
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Enter name"
                                            required
                                        />

                                    </div>


                                    <!-- EMAIL -->

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Email
                                        </label>

                                        <input
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            placeholder="Enter email"
                                            required
                                        />

                                    </div>


                                    <!-- PHONE -->

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Phone
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="phone"
                                            placeholder="Enter phone"
                                            required
                                        />

                                    </div>


                                    <!-- PASSWORD -->

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Password
                                        </label>

                                        <input
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="Enter password"
                                            required
                                        />

                                    </div>


                                    <!-- ADDRESS -->

                                    <div class="col-md-12 mb-3">

                                        <label class="form-label">
                                            Address
                                        </label>

                                        <textarea
                                            class="form-control"
                                            name="address"
                                            placeholder="Enter address"
                                        ></textarea>

                                    </div>


                                </div>


                                <!-- ===============================
                                     REGISTER BUTTON
                                     =============================== -->

                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                >
                                    Register
                                </button>

                            </form>


                            <!-- ===============================
                                 LOGIN LINK
                                 =============================== -->

                            <div class="text-center mt-3 small">

                                Already have an account?

                                <a href="{{ url('/user-login') }}">
                                    Login
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