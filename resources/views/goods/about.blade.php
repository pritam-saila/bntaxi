<!doctype html>
<html lang="en-GB">
    <head>
        
        <meta charset="UTF-8">
         <title>About Us | BN Taxi Anytime - Brighton Taxi Company</title>
  <meta name="description" content="Learn about BN Taxi Anytime, Brighton's trusted local taxi company. Licensed drivers, a modern fleet, and years of experience serving Brighton & Hove.">
  <meta name="keywords" content="Brighton taxi company">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        @include('goods.include.assets')
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

        <!-- ================= ABOUT ================= -->
        <section class="about">
            <div class="container about-wrapper">
                <!-- LEFT -->
                <div class="about-left">
                    <h2>{{ $about->heading ?? 'Brighton Taxi Company' }}</h2>

                    {!! $about->description ?? '<p>BN Taxi anytime is the leading taxi company in Brighton with approval from British Council. Our vehicles are regularly maintained and equipped with GPS tracking for safe travel.</p>' !!}

                    <div class="feature">
                        <h4>24 Hour Service</h4>
                        <p>Available all year round including holidays.</p>
                    </div>

                    <div class="feature">
                        <h4>Experienced Team</h4>
                        <p>Professional drivers with excellent route knowledge.</p>
                    </div>

                    <div class="feature">
                        <h4>Affordable Pricing</h4>
                        <p>Budget-friendly rates without compromising quality.</p>
                    </div>

                    <div class="feature">
                        <h4>Clean Vehicles</h4>
                        <p>Well-maintained and hygienic cars.</p>
                    </div>

                    <div class="feature">
                        <h4>Easy Booking</h4>
                        <p>Quick and hassle-free booking system.</p>
                    </div>

                    <div class="feature">
                        <h4>Safe & Secure</h4>
                        <p>DBS checked drivers and CCTV-enabled taxis.</p>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="about-right">
                    @if(isset($about->image) && $about->image)
                        <img src="{{ url(Storage::url($about->image)) }}" alt="{{ $about->heading }}" />
                    @else
                        <img src="{{url('goods')}}/images/brighton-city-council-logo-about.jpg" alt="Taxi" />
                    @endif

                    <div class="license">Fully Licensed by Brighton and Hove City Council</div>
                </div>
            </div>
        </section>
        @include('goods.include.footer')
    </body>
</html>
