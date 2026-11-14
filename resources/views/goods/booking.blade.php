<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        @include('goods.include.assets')
        
        @stylesheet('goods/css/pages/booking.css')
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

        <div class="container my-5">

            @if(isset($minimum) && $minimum['blocked'])
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-center p-5" style="background:#fff3f3; border:1px solid #f0c2c2; border-radius:14px;">
                            <i class="fa-solid fa-circle-exclamation" style="font-size:42px; color:#d9534f;"></i>
                            <h3 class="mt-3 mb-2" style="color:#b02a2a;">We can't take this booking</h3>
                            <p class="mb-2" style="font-size:16px;">
                                {{ $minimum['message'] }}
                            </p>
                            <p class="text-muted mb-4" style="font-size:14px;">
                                Your total journey (pickup, any stops and destination) is
                                <strong>{{ number_format($minimum['distance_miles'], 1) }} miles</strong>.
                                Our minimum is {{ rtrim(rtrim(number_format($minimum['minimum_miles'], 1), '0'), '.') }} miles.
                            </p>
                            <a href="{{ url('/') }}" class="btn btn-primary">Change your journey</a>
                            <a href="tel:+441273757373" class="btn btn-outline-secondary ms-2">Call us: 01273 757373</a>
                        </div>
                    </div>
                </div>
            @else

            <h2 class="text-center mb-4">Choose Your Vehicle</h2>

            @if(isset($minimum) && $minimum['below_minimum'] && !$minimum['enforced'])
                <div class="alert alert-warning text-center">
                    Heads up: this journey is {{ number_format($minimum['distance_miles'], 1) }} miles,
                    under our usual {{ rtrim(rtrim(number_format($minimum['minimum_miles'], 1), '0'), '.') }}-mile minimum.
                </div>
            @endif

            <div class="row g-4">

    @php
        usort($cars, function ($a, $b) {

            $nameA = strtolower(trim($a->name));
            $nameB = strtolower(trim($b->name));

            // Saloon Car = 1st
            if ($nameA === 'saloon car') {
                $rankA = 0;
            } elseif (str_contains($nameA, '8 seater')) {
                $rankA = 1;
            } else {
                $rankA = 2;
            }

            // 8 Seater = 2nd
            if ($nameB === 'saloon car') {
                $rankB = 0;
            } elseif (str_contains($nameB, '8 seater')) {
                $rankB = 1;
            } else {
                $rankB = 2;
            }

            return $rankA <=> $rankB;
        });
    @endphp

    @if(isset($cars) && count($cars) > 0)

        @foreach($cars as $car)

            <!-- ITEM -->
            <div class="col-md-6">

                <div class="bntaxi-item">

                    <div class="row align-items-center">

                        <!-- IMAGE -->
                        <div class="col-4">

                            @if($car->image)

                                <img
                                    src="{{ url(Storage::url($car->image)) }}"
                                    class="img-fluid"
                                />

                            @else

                                <img
                                    src="https://crcdiag.com/bntaxifinal/wp-content/uploads/Exploring-the-True-Essence-of-BN-Taxis-Brighton-Anytime-Luxury-Car-Hire-Service-400x250.jpg"
                                    class="img-fluid"
                                />

                            @endif

                        </div>


                        <!-- INFO -->
                        <div class="col-5">

                            <h5 class="mb-1">
                                {{ $car->name }}
                            </h5>

                            <small>
                                {{ $car->description ?? 'Up to 4 passengers' }}
                            </small>


                            @if($car->call_for_quote)

                                <div
                                    class="bntaxi-price"
                                    style="font-size: 15px; color: #d9534f; white-space: nowrap;"
                                >
                                    Please call for quotes
                                </div>

                            @else

                                <div class="bntaxi-price">
                                    £{{ number_format($car->calculated_price, 2) }}
                                </div>

                            @endif

                        </div>


                        <!-- BUTTON RIGHT -->
                        <div class="col-3 text-end">

                            @if($car->call_for_quote)

                                <a
                                    href="javascript:void(0)"
                                    class="btn btn-danger btn-sm"
                                    onclick="showNumber()"
                                    style="white-space: nowrap;"
                                >
                                    Call Now
                                </a>

                            @else

                                <button
                                    class="btn btn-primary btn-sm select-btn"
                                    onclick="selectCar(this)"
                                >
                                    Select
                                </button>

                            @endif

                        </div>

                    </div>


                    <!-- DRIVER -->
                    @if(!$car->call_for_quote)

                        <div class="bntaxi-driver-box">

                            <form action="{{ url('order-review') }}" method="GET">

                                <input
                                    type="hidden"
                                    name="car_id"
                                    value="{{ $car->id }}"
                                >

                                <input
                                    type="hidden"
                                    name="distance"
                                    value="{{ $distance ?? 0 }}"
                                >

                                <input
                                    type="hidden"
                                    name="price"
                                    value="{{ $car->calculated_price }}"
                                >

                                <input
                                    type="hidden"
                                    name="pickup"
                                    value="{{ $pickup ?? '' }}"
                                >

                                <input
                                    type="hidden"
                                    name="dropoff"
                                    value="{{ $dropoff ?? '' }}"
                                >

                                @if(isset($distancearr))

                                    @foreach($distancearr as $via)

                                        <input
                                            type="hidden"
                                            name="distancearr[]"
                                            value="{{ $via }}"
                                        >

                                    @endforeach

                                @endif

                                <input
                                    type="hidden"
                                    name="pickup_date"
                                    value="{{ $pickup_date ?? '' }}"
                                >

                                <input
                                    type="hidden"
                                    name="pickup_time"
                                    value="{{ $pickup_time ?? '' }}"
                                >

                                <input
                                    type="hidden"
                                    name="return_date"
                                    value="{{ $return_date ?? '' }}"
                                >

                                <input
                                    type="hidden"
                                    name="return_time"
                                    value="{{ $return_time ?? '' }}"
                                >

                                <input
                                    type="hidden"
                                    name="is_return"
                                    value="{{ $is_return ?? '0' }}"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-success w-100 mt-2"
                                >
                                    Continue
                                </button>

                            </form>

                        </div>

                    @endif

                </div>

            </div>

        @endforeach

    @else

        <div class="col-12 text-center">
            <p>No vehicles available for this route.</p>
        </div>

    @endif

</div>

            @endif {{-- minimum-distance block --}}
        </div>
        @include('goods.include.footer')
        
     <div id="phonePopup">

    <div class="phone-sheet">

        <div class="sheet-handle"></div>

        <div class="phone-icon">
            <i class="fa-solid fa-phone"></i>

        </div>

        <div class="phone-title">
            Call Us
        </div>

        <div class="phone-number">
            +44 01273 757373
        </div>

        <div class="phone-text">
            Available 24 Hours • 7 Days
        </div>

        <a href="tel:+441273757373" class="call-btn">
            Call Now
        </a>

        <button class="cancel-btn" onclick="closeNumber()">
            Cancel
        </button>

    </div>

</div>
        <script>
            function selectCar(btn) {
                document.querySelectorAll(".bntaxi-item").forEach((item) => {
                    item.classList.remove("active");
                });

                btn.closest(".bntaxi-item").classList.add("active");
            }
        </script>
        
        <script>
function showNumber(){

    document.getElementById("phonePopup").style.display="flex";

}

function closeNumber(){

    document.getElementById("phonePopup").style.display="none";

}

window.onclick=function(e){

    let popup=document.getElementById("phonePopup");

    if(e.target==popup){

        closeNumber();

    }

}
</script>
        
        
        <script>
            function selectCar(btn) {

    // সব Continue hide
    document.querySelectorAll('.bntaxi-driver-box').forEach(function(box){
        box.style.display = "none";
    });

    // সব Select আবার show
    document.querySelectorAll('.select-btn').forEach(function(button){
        button.style.display = "inline-block";
    });

    // যেটাতে ক্লিক হয়েছে সেটি hide
    btn.style.display = "none";

    // ওই কার্ডের Continue show
    btn.closest('.bntaxi-item')
       .querySelector('.bntaxi-driver-box')
       .style.display = "block";
}
        </script>
       
    </body>
</html>
