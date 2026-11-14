<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Business Travel Taxi Brighton | BN Taxi Anytime</title>
        <meta name="description" content="Reliable business travel transport in Brighton. Punctual, professional drivers for meetings, conferences & corporate trips. Book your taxi today.">
        <meta name="keywords" content="Business travel taxi Brighton">

        @include('goods.include.assets')
        
        @stylesheet('goods/css/pages/business-travel.css')
    </head>
    <body>
        @include('goods.include.header')

        <!-- ================= BANNER ================= -->
        <section class="banner">
            <div class="container banner-content">
                <h1>BN Taxi Anytime</h1>
                <p>Reliable & Professional Brighton Taxi Service</p>
            </div>
        </section>

      <section class="service-section">
    <div class="container">

        <!-- TOP CTA -->
        

        <div class="row">

            <!-- LEFT CONTENT -->
            <div class="col-lg-8">
                <h1 class="title">Brighton Private Taxi Hire</h1>

                <p>
                    Business travel in Brighton becomes easier as we provide minicabs for hire in Brighton.
                    Brighton Private Taxi Hire service by “BN Taxi anytime” gives you the freedom to travel anywhere and anytime.
                </p>

                <p>
                    Our Brighton Private Taxi Hire service offers well maintained and comfortable cars within your budget.
                    Seats are regularly cleaned to maintain hygiene.
                </p>

                <p>
                    We provide excellent chauffeur service with trained drivers ensuring safety and reliability.
                </p>

                <p>
                    Affordable pricing — up to 30% cheaper than traditional taxis.
                </p>

                <p>
                    24/7 available service at your doorstep. Book now and enjoy hassle-free travel.
                </p>
            </div>

            <!-- RIGHT SIDEBAR -->
            <div class="col-lg-4">

                <div class="image-box">
                    <img src="{{url('goods')}}/images/banner-2-1-2.jpg" alt="Taxi">
                </div>

                <div class="sidebar">
                    

                    <!-- CTA INSIDE -->
                    <a href="" class="btn-book w-100 mt-3">Book Now</a>
                </div>
               
            </div>

        </div>
    </div>
</section>
       
       
        @include('goods.include.footer')
    </body>
</html>
