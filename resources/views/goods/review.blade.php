<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>

        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" />

        @include('goods.include.assets')

        @stylesheet('goods/css/pages/review.css')
    </head>
    <body>
        @include('goods.include.header')

        <div class="banners" id="">
            <div class="banner-paras">
                <h1>Review</h1>
                <h5>Home // <a href=""> Review</a></h5>
            </div>
        </div>

        <div class="collection">
            <div class="container">
                <h3>PRICING</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pricingintxt1">
                            <div class="prictxtin">
                                <div class="prictxtin1">
                                    <i class="fa fa-truck"></i>
                                </div>
                                <div class="prictxtin2">
                                    <h5>Details</h5>
                                    <p>Car - {{$cardata->name}}</p>
                                </div>
                            </div>
                            @php
                                use Carbon\Carbon;

                                // Collection
                                $collectStart = Carbon::parse($collecttime_start)->format('d M Y, h:i A');
                                $collectEnd = $collectby === 'Between' ? Carbon::parse($collecttime_end)->format('h:i A') : null;

                                // Delivery
                                $deliveryStart = Carbon::parse($deliverytime_start)->format('d M Y, h:i A');
                                $deliveryEnd = $deliveryby === 'Between' ? Carbon::parse($deliverytime_end)->format('h:i A') : null;
                            @endphp

                            <div class="prictxtin2">
                                <h5>Collection</h5>
                                <p><span>Collect by -</span> {{ $collectby }}</p>
                                <p><span>Collect date -</span> {{ Carbon::parse($collecttime_start)->format('d M Y') }}</p>
                                <p><span>Collect time -</span>
                                    @if($collectby === 'Between')
                                        {{ Carbon::parse($collecttime_start)->format('h:i A') }} - {{ Carbon::parse($collecttime_end)->format('h:i A') }}
                                    @else
                                        {{ Carbon::parse($collecttime_start)->format('h:i A') }}
                                    @endif
                                </p>
                            </div>

                            <div class="prictxtin2">
                                <h5>Delivery</h5>
                                <p><span>Delivery by -</span> {{ $deliveryby }}</p>
                                <p><span>Delivery date -</span> {{ Carbon::parse($deliverytime_start)->format('d M Y') }}</p>
                                <p><span>Delivery time -</span>
                                    @if($deliveryby === 'Between')
                                        {{ Carbon::parse($deliverytime_start)->format('h:i A') }} - {{ Carbon::parse($deliverytime_end)->format('h:i A') }}
                                    @else
                                        {{ Carbon::parse($deliverytime_start)->format('h:i A') }}
                                    @endif
                                </p>
                            </div>


                            <p><span>Price for {{$cardata->name}} is £ {{$price}}</span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                       <div class="pricingintxt2">
                            <h4 id="pricing">£<span>{{$price}}</span></h4>
                            <h4 id="amt"></h4>
                            <h4>Complete Payment For Your Parcel</h4>
                            <div class="prictxtin3">
                                <!-- <input type="submit" value="USE COUPON" name="" class="sbmt_btn" data-bs-toggle="modal" data-bs-target="#exampleModal" id="usecoupon">
                                <button id="rmcoupon" style="display: none;" class="sbmt_btn" onclick="refresh()">REMOVE COUPON</button> -->
                                
                                @php

                                    // Collect Time
                                    $collectDate = Carbon::parse($collecttime_start)->format('Y-m-d');
                                    $collectTime = $collectby === 'Between'
                                        ? Carbon::parse($collecttime_start)->format('h:i A') . ' - ' . Carbon::parse($collecttime_end)->format('h:i A')
                                        : Carbon::parse($collecttime_start)->format('h:i A');

                                    // Delivery Time
                                    $deliveryDate = Carbon::parse($deliverytime_start)->format('Y-m-d');
                                    $deliveryTime = $deliveryby === 'Between'
                                        ? Carbon::parse($deliverytime_start)->format('h:i A') . ' - ' . Carbon::parse($deliverytime_end)->format('h:i A')
                                        : Carbon::parse($deliverytime_start)->format('h:i A');
                                @endphp
                                
                                @if(auth()->user())
                                    @if(auth()->user()->type == 0)
                                        <form action="<?= url('placeorder') ?>" method="post">
                                            @csrf
                                            <input type="hidden" name="car" id="car" value="{{$car}}" />
                                            <input type="hidden" name="price" id="price" value="{{$price}}" />
                                            <input type="hidden" name="distance" id="distance" value="{{$distance}}" />
                                            <input type="hidden" name="from" id="from" value="{{$from}}" />
                                            <input type="hidden" name="to" id="to" value="{{$to}}" />


                                            <input type="hidden" name="collectdate" id="collectdate" value="{{ $collectDate }}" />
                                            <input type="hidden" name="collectby" id="collectby" value="{{ $collectby }}" />
                                            <input type="hidden" name="collecttime" id="collecttime" value="{{ $collectTime }}" />
                                            <input type="hidden" name="deliverydate" id="deliverydate" value="{{ $deliveryDate }}" />
                                            <input type="hidden" name="deliveryby" id="deliveryby" value="{{ $deliveryby }}" />
                                            <input type="hidden" name="deliverytime" id="deliverytime" value="{{ $deliveryTime }}" />


                                            {{-- <input type="hidden" name="collectdate" id="collectdate" value="{{$collectdate}}" />
                                            <input type="hidden" name="collectby" id="collectby" value="{{$collectby}}" />
                                            <input type="hidden" name="collecttime" id="collecttime" value="{{$collecttime}}" />
                                            <input type="hidden" name="deliverydate" id="deliverydate" value="{{$deliverydate}}" />
                                            <input type="hidden" name="deliveryby" id="deliveryby" value="{{$deliveryby}}" />
                                            <input type="hidden" name="deliverytime" id="deliverytime" value="{{$deliverytime}}" /> --}}


                                            <input type="text" name="name" placeholder="Please Enter Reciver Name" value="{{auth()->user()->name}}" class="form-control form-control-sm mb-1" required>

                                            <input type="text" name="email" placeholder="Please Enter Reciver Email" value="{{auth()->user()->email}}" 
                                            class="form-control form-control-sm mb-1" required>


                                            <input type="text" name="phone" placeholder="Please Enter Reciver Phone" value="{{auth()->user()->phone}}" 
                                            class="form-control form-control-sm mb-1" required>
                                            
                                            <input type="submit" value="BOOK NOW" name="" class="btn btn-primary" onclick="return validate()">
                                        </form>
                                    @endif
                                @else 
                                    <a href="{{url('/user-login')}}" class="btn btn-primary">BOOK NOW</a>
                                @endif
                                
                            </div>
                       </div>
                    </div>
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
        </script>
    </body>
</html>
