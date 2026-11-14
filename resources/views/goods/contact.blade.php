<!doctype html>
<html lang="en-GB">
<head>

    <meta charset="UTF-8">

    <title>Contact Us | BN Taxi Anytime</title>

    <meta
        name="description"
        content="Get in touch with BN Taxi Anytime to book a taxi, request a quote or ask a question. Call, email or book online - available 24/7 across Brighton."
    >

    <meta
        name="keywords"
        content="Contact BN Taxi Anytime"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    @include('goods.include.assets')


    <style>

        /* =========================================================
           BN TAXI CONTACT PAGE
           PREMIUM HEAVY ROYAL BLUE + WHITE DESIGN
           Dynamic-safe
           ========================================================= */

        :root {
            --bn-blue: #1557d6;
            --bn-blue-dark: #0b3d9e;
            --bn-blue-deep: #082f7d;

            --bn-light-blue: #eaf3ff;
            --bn-soft-blue: #f5f9ff;

            --bn-white: #ffffff;

            --bn-text: #12264a;
            --bn-muted: #68778f;

            --bn-border: #d9e4f4;
        }


        /* =========================================================
           BODY
           ========================================================= */

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        body {
            background: #f5f8fd;
            color: var(--bn-text);

            font-family:
                "Poppins",
                Arial,
                Helvetica,
                sans-serif;
        }


        /* =========================================================
           BANNER
           ========================================================= */

        .banner {
            position: relative;

            overflow: hidden;

            padding: 62px 15px;

            background:
                radial-gradient(
                    circle at 85% 15%,
                    rgba(255,255,255,.14),
                    transparent 190px
                ),
                linear-gradient(
                    135deg,
                    var(--bn-blue-deep) 0%,
                    var(--bn-blue-dark) 45%,
                    var(--bn-blue) 100%
                );

            color: #fff;

            border-bottom:
                5px solid rgba(21,87,214,.18);
        }


        .banner::before {
            content: "";

            position: absolute;

            width: 330px;
            height: 330px;

            right: -180px;
            top: -190px;

            border:
                55px solid
                rgba(255,255,255,.07);

            border-radius: 50%;
        }


        .banner::after {
            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            left: -140px;
            bottom: -160px;

            border:
                35px solid
                rgba(255,255,255,.05);

            border-radius: 50%;
        }


        .banner-content {
            position: relative;

            z-index: 2;

            text-align: center;
        }


        .banner-content h1 {
            margin: 0 0 8px;

            color: #fff;

            font-size:
                clamp(28px, 4vw, 42px);

            line-height: 1.1;

            font-weight: 850;

            letter-spacing: -.5px;
        }


        .banner-content p {
            margin: 0;

            color:
                rgba(255,255,255,.78);

            font-size: 14px;

            font-weight: 500;
        }


        /* =========================================================
           CONTACT SECTION
           ========================================================= */

        .contacts {
            position: relative;

            overflow: hidden;

            padding: 65px 15px 75px;

            background:
                radial-gradient(
                    circle at 8% 15%,
                    rgba(21,87,214,.07),
                    transparent 220px
                ),
                radial-gradient(
                    circle at 94% 85%,
                    rgba(21,87,214,.06),
                    transparent 220px
                ),
                linear-gradient(
                    135deg,
                    #eaf3ff 0%,
                    #f8fbff 50%,
                    #edf5ff 100%
                );
        }


        /* =========================================================
           CONTACT WRAPPER
           ========================================================= */

        .contact-wrapper {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1fr);

            gap: 25px;

            max-width: 1120px;

            margin: 0 auto;

            align-items: stretch;
        }


        /* =========================================================
           CONTACT CARD
           ========================================================= */

        .contact-card {
            position: relative;

            overflow: hidden;

            padding: 34px;

            background: #fff;

            border:
                1px solid
                rgba(21,87,214,.12);

            border-radius: 22px;

            box-shadow:
                0 22px 55px
                rgba(8,47,125,.13),

                0 5px 18px
                rgba(8,47,125,.06);
        }


        /* Top blue line */

        .contact-card::before {
            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 5px;

            background:
                linear-gradient(
                    90deg,
                    var(--bn-blue-deep),
                    var(--bn-blue),
                    var(--bn-blue-deep)
                );
        }


        /* =========================================================
           CONTACT TITLE
           ========================================================= */

        .contact-card h2 {
            margin:
                0 0 27px;

            color: var(--bn-text);

            font-size: 27px;

            line-height: 1.2;

            font-weight: 850;

            letter-spacing: -.3px;
        }


        .contact-card h2::after {
            content: "";

            display: block;

            width: 48px;
            height: 4px;

            margin-top: 10px;

            border-radius: 20px;

            background:
                linear-gradient(
                    90deg,
                    var(--bn-blue),
                    var(--bn-blue-dark)
                );
        }


        /* =========================================================
           CONTACT ITEM
           ========================================================= */

        .contact-item {
            position: relative;

            margin-bottom: 13px;

            padding: 15px 17px;

            background:
                linear-gradient(
                    135deg,
                    #f7faff,
                    #edf5ff
                );

            border:
                1px solid
                var(--bn-border);

            border-radius: 12px;

            transition:
                transform .22s ease,
                border-color .22s ease,
                box-shadow .22s ease;
        }


        .contact-item:hover {
            transform:
                translateY(-2px);

            border-color:
                rgba(21,87,214,.28);

            box-shadow:
                0 8px 20px
                rgba(21,87,214,.08);
        }


        .contact-item h4 {
            margin: 0 0 4px;

            color: var(--bn-blue-dark);

            font-size: 11px;

            font-weight: 850;

            text-transform: uppercase;

            letter-spacing: .7px;
        }


        .contact-item p {
            margin: 0;

            color: var(--bn-text);

            font-size: 14px;

            font-weight: 650;

            line-height: 1.5;

            word-break: break-word;
        }


        /* =========================================================
           FORM
           ========================================================= */

        .form {
            margin-top: 23px;
        }


        .form input,
        .form textarea {
            display: block;

            width: 100%;

            box-sizing: border-box;

            margin-bottom: 12px;

            padding: 13px 15px;

            background: #fff;

            color: var(--bn-text);

            border:
                1.5px solid
                var(--bn-border);

            border-radius: 10px;

            outline: none;

            font-family: inherit;

            font-size: 13px;

            font-weight: 550;

            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }


        .form input {
            height: 49px;
        }


        .form textarea {
            min-height: 105px;

            resize: vertical;
        }


        .form input::placeholder,
        .form textarea::placeholder {
            color: #8a98ab;
        }


        .form input:focus,
        .form textarea:focus {
            border-color:
                var(--bn-blue);

            box-shadow:
                0 0 0 3px
                rgba(21,87,214,.10);
        }


        /* =========================================================
           SEND BUTTON
           ========================================================= */

        .form button {
            width: 100%;

            min-height: 50px;

            padding: 12px 20px;

            border: 0;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    var(--bn-blue),
                    var(--bn-blue-dark)
                );

            color: #fff;

            font-family: inherit;

            font-size: 13px;

            font-weight: 800;

            letter-spacing: .2px;

            cursor: pointer;

            box-shadow:
                0 9px 22px
                rgba(21,87,214,.22);

            transition:
                transform .22s ease,
                box-shadow .22s ease,
                background .22s ease;
        }


        .form button:hover {
            background:
                linear-gradient(
                    135deg,
                    var(--bn-blue-dark),
                    var(--bn-blue-deep)
                );

            transform:
                translateY(-2px);

            box-shadow:
                0 13px 27px
                rgba(21,87,214,.28);
        }


        .form button:active {
            transform:
                translateY(0);
        }


        /* =========================================================
           MAP
           ========================================================= */

        .map {
            position: relative;

            min-height: 100%;

            overflow: hidden;

            background: #fff;

            border:
                1px solid
                rgba(21,87,214,.13);

            border-radius: 22px;

            box-shadow:
                0 22px 55px
                rgba(8,47,125,.13),

                0 5px 18px
                rgba(8,47,125,.06);
        }


        .map::before {
            content: "BN TAXI ANYTIME";

            position: absolute;

            left: 18px;
            top: 18px;

            z-index: 2;

            padding: 8px 12px;

            border-radius: 8px;

            background:
                rgba(8,47,125,.92);

            color: #fff;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: .7px;

            pointer-events: none;

            box-shadow:
                0 5px 15px
                rgba(0,0,0,.12);
        }


        .map iframe {
            display: block;

            width: 100%;

            height: 100%;

            min-height: 550px;

            border: 0;

            filter:
                saturate(.92)
                contrast(1.02);
        }


        /* =========================================================
           TABLET
           ========================================================= */

        @media (max-width: 991px) {

            .banner {
                padding: 50px 15px;
            }


            .contacts {
                padding: 48px 15px 60px;
            }


            .contact-wrapper {
                grid-template-columns: 1fr;

                max-width: 760px;

                gap: 20px;
            }


            .map {
                min-height: 430px;
            }


            .map iframe {
                min-height: 430px;
            }
        }


        /* =========================================================
           MOBILE
           ========================================================= */

        @media (max-width: 767px) {

            .banner {
                padding: 42px 12px;
            }


            .banner-content h1 {
                font-size: 29px;
            }


            .banner-content p {
                font-size: 12px;
            }


            .contacts {
                padding: 30px 10px 45px;
            }


            .contact-wrapper {
                gap: 16px;
            }


            .contact-card {
                padding: 24px 18px;

                border-radius: 17px;
            }


            .contact-card h2 {
                font-size: 23px;

                margin-bottom: 20px;
            }


            .contact-item {
                padding: 13px 14px;

                margin-bottom: 10px;
            }


            .contact-item h4 {
                font-size: 10px;
            }


            .contact-item p {
                font-size: 13px;
            }


            .form {
                margin-top: 19px;
            }


            .form input {
                height: 46px;
            }


            .form textarea {
                min-height: 95px;
            }


            .map {
                border-radius: 17px;
            }


            .map iframe {
                min-height: 360px;
            }


            .map::before {
                left: 12px;
                top: 12px;

                font-size: 8px;
            }
        }


        /* =========================================================
           SMALL MOBILE
           ========================================================= */

        @media (max-width: 480px) {

            .banner {
                padding: 35px 10px;
            }


            .banner-content h1 {
                font-size: 25px;
            }


            .banner-content p {
                font-size: 11px;
            }


            .contacts {
                padding:
                    22px 7px 35px;
            }


            .contact-card {
                padding: 21px 14px;

                border-radius: 15px;
            }


            .contact-card h2 {
                font-size: 21px;
            }


            .contact-item {
                padding: 12px;
            }


            .contact-item p {
                font-size: 12px;
            }


            .form input,
            .form textarea {
                font-size: 12px;
            }


            .form button {
                min-height: 47px;

                font-size: 12px;
            }


            .map iframe {
                min-height: 320px;
            }
        }

    </style>

</head>


<body>


    @include('goods.include.header')


    <!-- =========================================================
         PREMIUM CONTACT BANNER
         ========================================================= -->

    <section class="banner">

        <div class="container banner-content">

            <h1>
                BN Taxi Anytime
            </h1>

            <p>
                Reliable &amp; Professional Brighton Taxi Service
            </p>

        </div>

    </section>


    <!-- =========================================================
         CONTACT SECTION
         ========================================================= -->

    <section class="contacts">

        <div class="container">

            <div class="contact-wrapper">


                <!-- =================================================
                     LEFT - CONTACT DETAILS + FORM
                     ================================================= -->

                <div class="contact-card">

                    <h2>
                        Get in Touch
                    </h2>


                    <div class="contact-item">

                        <h4>
                            Phone
                        </h4>

                        <p>
                            01273757373
                        </p>

                    </div>


                    <div class="contact-item">

                        <h4>
                            Email
                        </h4>

                        <p>
                            info@bntaxianytime.com
                        </p>

                    </div>


                    <div class="contact-item">

                        <h4>
                            Address
                        </h4>

                        <p>
                            Brighton &amp; Hove, United Kingdom
                        </p>

                    </div>


                    <div class="contact-item">

                        <h4>
                            Working Hours
                        </h4>

                        <p>
                            24 Hours Service Available
                        </p>

                    </div>


                    <!-- =================================================
                         CONTACT FORM
                         Existing form structure preserved
                         ================================================= -->

                    @if(session('success'))
                        <div style="background:#d4edda;color:#155724;border:1px solid #b7dfc0;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:14px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="background:#f8d7da;color:#721c24;border:1px solid #f1b0b7;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(isset($errors) && $errors->any())
                        <div style="background:#fff3cd;color:#856404;border:1px solid #ffe08a;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:14px;">
                            <ul style="margin:0;padding-left:18px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form" method="POST" action="{{ route('frontend.contact') }}">

                        @csrf

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Your Name"
                            required
                        />

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Your Email"
                            required
                        />

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Your Phone (optional)"
                        />

                        <textarea
                            name="message"
                            rows="4"
                            placeholder="Your Message"
                            required
                        >{{ old('message') }}</textarea>

                        <input type="text" name="website" tabindex="-1" autocomplete="off"
                               style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;" aria-hidden="true" />

                        <button type="submit">
                            Send Message
                        </button>

                    </form>

                </div>


                <!-- =================================================
                     RIGHT - GOOGLE MAP
                     ================================================= -->

                <div class="map">

                    <iframe
                        src="https://maps.google.com/maps?q=Brighton&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>


            </div>

        </div>

    </section>


    @include('goods.include.footer')


</body>

</html>