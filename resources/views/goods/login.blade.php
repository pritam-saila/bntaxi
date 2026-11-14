<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>BN Taxi Anytime - Login</title>

    @include('goods.include.assets')

    @stylesheet('goods/css/pages/login.css')
</head>

<body>

    @include('goods.include.header')


    <!-- ============================
         PAGE BANNER
    ============================= -->

    <div class="banners">

        <div class="banner-paras">

            <h1>Login</h1>

            <h5>
                Home //
                <a href="">
                    Login
                </a>
            </h5>

        </div>

    </div>


    <!-- ============================
         QUOTE STRIP
    ============================= -->

    <div class="banner_bottom">

        <div class="container">

            <h2>

                <span>
                    Get a FREE Instant Quote Here
                </span>

                <span>
                    Get A Quote
                </span>

            </h2>

        </div>

    </div>


    <!-- ============================
         LOGIN
    ============================= -->

    <main class="main pages">

        <div class="page-content pt-50 pb-50">

            <div class="container">

                <div class="row">

                    <div class="col-md-12">


                        <div class="login_wrap widget-taber-content background-white">

                            <div class="padding_eight_all bg-white">


                                <!-- HEADING -->

                                <div class="heading_s1">

                                    <h1 class="mb-3">
                                        Login
                                    </h1>


                                    @if(session()->has('success'))

                                    <div
                                        class="alert alert-success mb-0 alert-dismissible fade show"
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


                                    @if(session()->has('error'))

                                    <div
                                        class="alert alert-danger mb-0 alert-dismissible fade show"
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


                                    <p class="mb-30">

                                        Don't have an account?

                                        <a href="{{url('/user-register')}}">
                                            Create here
                                        </a>

                                    </p>

                                </div>


                                <!-- FORM -->

                                <form
                                    method="POST"
                                    action="{{ route('login') }}"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="type"
                                        value="0"
                                    >


                                    <!-- USERNAME / EMAIL -->

                                    <div class="form-group">

                                        <input
                                            type="text"
                                            required=""
                                            name="email"
                                            placeholder="Username or Email *"
                                        />

                                    </div>


                                    <!-- PASSWORD -->

                                    <div class="form-group">

                                        <input
                                            required=""
                                            type="password"
                                            name="password"
                                            placeholder="Your password *"
                                        />

                                    </div>


                                    <!-- FORGOT PASSWORD -->

                                    <div class="login_footer form-group mb-50">

                                        <a
                                            class="text-muted"
                                            href="#"
                                        >
                                            Forgot password?
                                        </a>

                                    </div>


                                    <!-- LOGIN BUTTON -->

                                    <div class="form-group">

                                        <button
                                            type="submit"
                                            class="btn btn-heading btn-block hover-up"
                                            name="login"
                                        >
                                            Log in
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>


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