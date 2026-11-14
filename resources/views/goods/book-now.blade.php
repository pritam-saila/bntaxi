<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>BN Taxi Anytime</title>

        @include('goods.include.assets')

        @stylesheet('goods/css/pages/book-now.css')
    </head>

    <body>

        @include('goods.include.header')


        <!-- =========================================================
             PREMIUM BOOKING / GET A QUOTE AREA
             ========================================================= -->

        <main class="bn-heavy-booking-area">

            <div class="bn-heavy-booking-decoration"></div>

            <div class="bn-heavy-booking-content">

                {{-- KEEP THIS DYNAMIC SYSTEM EXACTLY AS IT IS --}}
                @include('goods.include.get-a-quote')

            </div>

        </main>


        @include('goods.include.footer')


        <!-- =========================================================
             OWL CAROUSEL
             ========================================================= -->

        <script
            type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"
        ></script>


        <script>
            $(document).ready(function () {

                $(".testimonial_owlCarousel").owlCarousel({

                    loop: true,

                    margin: 10,

                    dots: false,

                    nav: true,

                    autoplay: false,

                    smartSpeed: 3000,

                    autoplayTimeout: 4000,

                    responsive: {

                        0: {
                            items: 1,
                        },

                        600: {
                            items: 1,
                        },

                        1000: {
                            items: 1,
                        },

                    },

                });

            });
        </script>

    </body>
</html>