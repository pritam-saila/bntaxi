<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>

        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" />

        @include('goods.include.assets')

        @stylesheet('goods/css/pages/quote-details.css')
    </head>
    <body>
        @include('goods.include.header')

        <div class="banners" id="banners">
            <div class="banner-paras">
                <h1>Get Quote</h1>
                <h5>Home // <a href=""> Get Quote</a></h5>
            </div>
        </div>

        <div class="progreess">
            <div class="container">
                <div class="progress-container">
                    <div class="progress" id="progress"></div>
                    <div class="circle active">
                        <p>Delivery</p>
                    </div>

                    <div class="circle active">
                        <p>Quote</p>
                    </div>
                    <div class="circle">
                        <p>Payment</p>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="quote-details">
            <div class="container">
                <div class="row no-gutters" id="pickups">
                    <div class="col-md-10">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="pickups">
                                    <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                    <h4>Pickup from: <span>{{$to}}</span></h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="pickups">
                                    <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                    <h4>Destination: <span>{{$from}}</span></h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="pickups">
                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                    <h4>Collection: <span>{{$currenttime}} if Booked Now</span></h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="pickups">
                                    <i class="fa fa-clock" aria-hidden="true"></i>
                                    <h4>Earliest Delivery Time: <span>{{$esttime}}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="quots">
                            <h6>Back</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function option(id,price) {
                $('#car').val(id);
                $('#price').val(price);
                $('#formin').submit();
            }
        </script>

        <div class="collection">
            <div class="container">
                <form action="{{route('review')}}" method="GET" id="formin">
                    <input type="hidden" name="car" id="car" />
                    <input type="hidden" name="price" id="price" />
                    <input type="hidden" name="distance" id="distance" value="{{$distance}}" />
                    <input type="hidden" name="from" id="from" value="{{$from}}" />
                    <input type="hidden" name="to" id="to" value="{{$to}}" />
                    <div class="row">

                        <!-- Collection Section -->
                        <div class="col-md-1">
                            <select name="collectby" id="collectby">
                                <option value="Between">Between</option>
                                <option value="Before">Before</option>
                                <option value="At">At</option>
                            </select>
                        </div>
                        <div class="col-md-5" id="collect-datetime-container">
                            <input type="datetime-local" name="collecttime_start" id="collecttime_start"
                                value="{{ \Carbon\Carbon::now('Europe/London')->format('Y-m-d\TH:i') }}" />

                            <input type="datetime-local" name="collecttime_end" id="collecttime_end"
                                value="{{ \Carbon\Carbon::now('Europe/London')->addHour()->format('Y-m-d\TH:i') }}" />
                        </div>

                        <!-- Delivery Section -->
                        <div class="col-md-1">
                            <select name="deliveryby" id="deliveryby">
                                <option value="Between">Between</option>
                                <option value="Before">Before</option>
                                <option value="At">At</option>
                            </select>
                        </div>
                        <div class="col-md-5" id="delivery-datetime-container">
                            <input type="datetime-local" name="deliverytime_start" id="deliverytime_start"
                                value="{{ \Carbon\Carbon::now('Europe/London')->addHour()->format('Y-m-d\TH:i') }}" />

                            <input type="datetime-local" name="deliverytime_end" id="deliverytime_end"
                                value="{{ \Carbon\Carbon::now('Europe/London')->addHours(2)->format('Y-m-d\TH:i') }}" />
                        </div>


                    </div>
                </form>
            </div>
        </div>

        <div class="smallvans">
            <div class="container">
                <div class="row">

                    @foreach ($cars as $item)

                    <div class="col-md-4">
                        <div class="vans">
                            <img src="{{url(Storage::url($item->image))}}" />
                            <h2>{{$item->name}}</h2>
                            <hr />
                            {!! $item->description !!}
                            <hr />
                            <h3>Price<span>£ {{ $item->priceorg }}</h3>
                            <p class="text-right">{{ $item->vat }}</p>
                            <hr />
                            <h3>VAT added Price<span>£ {{$item->priceing}}</span></h3>
                            <h6><a onclick="option({{$item->id}},{{$item->priceing}})">Choose this option</a></h6>
                        </div>
                    </div>
                        
                    @endforeach


                </div>
            </div>
        </div>

        <img src="images/details-banner.jpg" />

        @include('goods.include.footer')
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
        <script>
            var today, datepicker;
            today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            datepicker = $("#datepicker").datepicker({
                minDate: today,
                format: "yyyy-mm-dd",
            });
        </script>

        <script>
            document.querySelector("input[type='time']").addEventListener("input", function () {
                const reTime = /^([0-1][0-9]|2[0-3]):[0-5][0-9]$/;
                if (reTime.exec(this.value)) {
                    const minute = Number(this.value.substring(3, 5));
                    const hour = (Number(this.value.substring(0, 2)) % 12) + minute / 60;
                    this.style.backgroundImage = `url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40'><circle cx='20' cy='20' r='18.5' fill='none' stroke='%23222' stroke-width='3' /><path d='M20,4 20,8 M4,20 8,20 M36,20 32,20 M20,36 20,32' stroke='%23bbb' stroke-width='1' /><g fill='%23222' stroke='%23222' stroke-width='2'><circle cx='20' cy='20' r='2' /><path d='M20,24 20,5' style='transform:rotate(${
                        (360 * minute) / 60
                    }deg); transform-origin: 50% 50%;' /><path d='M20,24 20,8' style='transform:rotate(${(360 * hour) / 12}deg); transform-origin: 50% 50%;' /></g></svg>")`;
                }
            });


        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const collectBy = document.getElementById('collectby');
                const collectTimeStart = document.getElementById('collecttime_start');
                const collectTimeEnd = document.getElementById('collecttime_end');

                const deliveryBy = document.getElementById('deliveryby');
                const deliveryTimeStart = document.getElementById('deliverytime_start');
                const deliveryTimeEnd = document.getElementById('deliverytime_end');

                function updateTimeInputs(bySelect, startInput, endInput) {
                    const selected = bySelect.value;

                    if (selected === 'Between') {
                        startInput.style.display = 'inline-block';
                        endInput.style.display = 'inline-block';
                    } else {
                        startInput.style.display = 'inline-block';
                        endInput.style.display = 'none';
                    }
                }

                // On initial load
                updateTimeInputs(collectBy, collectTimeStart, collectTimeEnd);
                updateTimeInputs(deliveryBy, deliveryTimeStart, deliveryTimeEnd);

                // On change
                collectBy.addEventListener('change', () => {
                    updateTimeInputs(collectBy, collectTimeStart, collectTimeEnd);
                });

                deliveryBy.addEventListener('change', () => {
                    updateTimeInputs(deliveryBy, deliveryTimeStart, deliveryTimeEnd);
                });
            });
        </script>
       <!--  <script>
            const progress = document.getElementById("progress");
            const prev = document.getElementById("prev");
            const next = document.getElementById("next");
            const circles = document.querySelectorAll(".circle");

            let currentActive = 1;

            next.addEventListener("click", () => {
                currentActive++;
                if (currentActive > circles.length) {
                    currentActive = circles.length;
                }
                update();
            });

            prev.addEventListener("click", () => {
                currentActive--;
                if (currentActive < 1) {
                    currentActive = 1;
                }
                update();
            });

            function update() {
                circles.forEach((circle, index) => {
                    if (index < currentActive) {
                        circle.classList.add("active");
                    } else {
                        circle.classList.remove("active");
                    }
                });
                const actives = document.querySelectorAll(".active");
                progress.style.width = `${((actives.length - 1) / (circles.length - 1)) * 100}%`;

                if (currentActive === 1) {
                    prev.disabled = true;
                } else if (currentActive === circles.length) {
                    next.disabled = true;
                } else {
                    prev.disabled = false;
                    next.disabled = false;
                }
            }
        </script> -->
    </body>
</html>
