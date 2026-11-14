<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $service->title ?? 'Service Details' }} | BN Taxi Anytime</title>
        @if(isset($service))
        <meta name="keywords" content="{{ $service->metatag ?? '' }}">
        <meta name="description" content="{{ $service->metadescription ?? '' }}">
        @endif

        @include('goods.include.assets')
    </head>
    <body>
        @include('goods.include.header')

        <!-- ================= BANNER ================= -->
        <section class="banner">
            <div class="container banner-content">
                <h1>{{ $service->title ?? 'Service Details' }}</h1>
                <p>Reliable & Professional Brighton Taxi Service</p>
            </div>
        </section>

        <!-- ================= ABOUT ================= -->
        <section class="about">
            <div class="container about-wrapper">
                <!-- LEFT -->
                <div class="about-left">
                    <h2>{{ $service->title ?? 'Service' }}</h2>

                    {!! $service->description ?? '<p>Service description not available.</p>' !!}
                </div>

                <!-- RIGHT -->
                <div class="about-right">
                    @if(isset($service->image) && $service->image)
                        <img src="{{ url(Storage::url($service->image)) }}" alt="{{ $service->title }}" />
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