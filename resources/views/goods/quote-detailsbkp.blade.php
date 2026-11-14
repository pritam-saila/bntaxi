<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>

        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" />

        @include('goods.include.assets')

        <style>
            .pickups {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .pickups i {
                font-size: 15px;
                font-weight: bold;
                width: 17%;
                color: #267fca;
            }
            .pickups h4 {
                font-size: 14px;
                font-weight: 400;
                display: grid;
                line-height: 20px;
                color: #fff;
            }
            .pickups span {
                font-weight: bold;
            }
            #pickups {
                background: #101d3b;
                margin: 25px 0;
                padding: 15px 0;
                border-radius: 5px;
            }
            .quots {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .quots i {
                color: #267fca;
            }
            .quots h6 {
                color: #fff;
                margin: 0;
                line-height: 42px;
            }

            /*datepicker////////*/
            .dates {
                width: 100%;
            }
            .collection h2 {
                font-size: 15px;
                font-weight: bold;
            }

            .vans {
                box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                padding: 15px;
                margin-bottom: 20px;
            }
            .vans h2 {
                font-weight: bold;
                font-size: 20px;
                text-align: center;
            }
            .vans h5 {
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 14px;
                font-weight: 400;
                line-height: 25px;
            }

            .vans h3 {
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 15px;
                font-weight: 600;
                line-height: 25px;
            }
            .vans img {
                width: 100%;
            }
            .vans h6 {
                font-weight: bold;
                color: #fff;
            }
            .vans h6 a {
                background: #101d3b;
                width: 100%;
                display: block;
                /* margin: 10px; */
                text-align: center;
                padding: 8px;
                color: #fff;
                border-radius: 10px;
                width: 80%;
                margin: 20px auto 0 auto;
            }

            .dates input[type="time"] {
                padding-left: 1.5em;
                background-repeat: no-repeat;
                background-position: 0.25em center;
                background-size: 1em;
                background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40'><circle cx='20' cy='20' r='18.5' fill='none' stroke='%23222' stroke-width='3' /><path d='M20,4 20,8 M4,20 8,20 M36,20 32,20 M20,36 20,32' stroke='%23bbb' stroke-width='1' /><g fill='%23222' stroke='%23222' stroke-width='2'><circle cx='20' cy='20' r='2' /><path d='M20,24 20,5' style='transform:rotate(120deg); transform-origin: 50% 50%;' /><path d='M20,24 20,8' style='transform:rotate(20deg); transform-origin: 50% 50%;' /></g></svg>");
                /* this style to complete the styling*/
                border: 0.125em solid #369;
                border-radius: 0.25em;
                font-size: 1rem;
            }

            #coocolor {
                background: #f1f1f1;
                padding: 10px 0;
            }
            .collection {
                margin: 30px 0;
            }
        
            .progress-container {
                display: flex;
                justify-content: space-between;
                margin-bottom: 30px;
                max-width: 100%;
                width: 350px;
                position: relative;
            }

            .progress-container::before {
                content: "";
                background-color: #e0e0e0;
                position: absolute;
                top: 50%;
                left: 0;
                height: 4px;
                width: 100%;
                transform: translateY(-50%);
                z-index: -1;
            }

            .progress {
                background-color: #3498db;
                position: absolute;
                top: 50%;
                left: 0;
                height: 4px;
                width: 50%;
                transform: translateY(-50%);
                z-index: -1;
                transition: 0.4s ease;
            }

            .circle {
                background-color: white;
                color: #999;
                border-radius: 50%;
                height: 30px;
                width: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 3px solid #e0e0e0;
                transition: 0.4s ease;
            }

            .circle.active {
                border-color: #3498db;
            }

            .btn {
                background-color: #3498db;
                color: #fff;
                border: 0;
                border-radius: 6px;
                cursor: pointer;
                font-family: inherit;
                padding: 8px 30px;
                margin: 5px;
                font-size: 14px;
            }

            .btn:active {
                transform: scale(0.98);
            }

            .btn:focus {
                outline: 0;
            }

            .btn:disabled {
                background-color: #e0e0e0;
                cursor: not-allowed;
            }

            .progreess {
            }
            .progress-container {
                text-align: center;
                margin: 0 auto;
            }
            .progreess {
                width: 45%;
                margin: 0 auto;
                text-align: center;
                /*    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;*/
                padding: 30px 0 0 0;
                position: absolute;
                bottom: 210px;
                left: 27%;
                background-color: #fff;
                z-index: 11111;
                border-radius: 15px;
            }

            .circle p {
                margin-top: 60px;
                font-weight: bold;
            }
            .progreess button {
                margin: 40px 0;
            }
            #banners {
                position: relative;
                margin-bottom: 150px;
            }
            #collecttime_end,
            #deliverytime_end {
                margin-left: 10px;
            }

        </style>
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
                        <div class="col-md-3">
                            <select name="collectby" id="collectby">
                                <option value="Between">Between</option>
                                <option value="Before">Before</option>
                                <option value="At">At</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="collect-datetime-container">
                            <input type="datetime-local" name="collecttime_start" id="collecttime_start"
                                value="{{ \Carbon\Carbon::now('Europe/London')->format('Y-m-d\TH:i') }}" />

                            <input type="datetime-local" name="collecttime_end" id="collecttime_end"
                                value="{{ \Carbon\Carbon::now('Europe/London')->addHour()->format('Y-m-d\TH:i') }}" />
                        </div>

                        <!-- Delivery Section -->
                        <div class="col-md-3">
                            <select name="deliveryby" id="deliveryby">
                                <option value="Between">Between</option>
                                <option value="Before">Before</option>
                                <option value="At">At</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="delivery-datetime-container">
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
                            <h3>Price<span>£ {{$item->priceing}}</span></h3>
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
