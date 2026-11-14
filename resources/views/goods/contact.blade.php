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


    @stylesheet('goods/css/pages/contact.css')

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