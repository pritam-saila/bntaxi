<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime | {{$data->title}}</title>

        @include('goods.include.assets')
    </head>
    <body>
        @include('goods.include.header')

        <div class="banners">
            <div class="banner-paras">
                <h1>{{$data->heading}}</h1>
                <!-- <h5>Home // <a href=""> Same Day Courier Service</a></h5> -->
            </div>
        </div>

        <div class="banner_bottom">
            <div class="container">
                <h2>Get a FREE Instant Quote Here <span>Get A Quote</span></h2>
            </div>
        </div>


        <div class="contain_para">
            <div class="container">
                {!! $data->description !!}

                <img src="{{url(Storage::url($data->image))}}" />

            </div>
        </div>

        @include('goods.include.footer')

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
    </body>
</html>
