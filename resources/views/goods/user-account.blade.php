<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>BN Taxi Anytime | User Account</title>

    @include('goods.include.assets')

    @stylesheet('goods/css/pages/user-account.css')
</head>


<body>

@include('goods.include.header')


<div class="bntaxi-dashboard">

    <div class="container">

        <div class="row g-4">


            <!-- =================================================
                 SIDEBAR
            ================================================== -->

            <div class="col-md-3 bntaxi-sidebar">

                @include('goods.include.dashboad-menu')

            </div>


            <!-- =================================================
                 MAIN
            ================================================== -->

            <div class="col-md-9 bntaxi-main">

                <div class="bntaxi-main">


                    <h4 class="mb-4">
                        Dashboard
                    </h4>


                    <!-- =================================================
                         STATISTICS
                    ================================================== -->

                    <div class="row g-3">


                        <!-- Upcoming Ride -->

                        <div class="col-md-4">

                            <div class="bntaxi-card">

                                <h6>
                                    Upcoming Ride
                                </h6>

                                <p>
                                    No upcoming rides
                                </p>

                            </div>

                        </div>


                        <!-- Total Bookings -->

                        <div class="col-md-4">

                            <div class="bntaxi-card">

                                <h6>
                                    Total Bookings
                                </h6>

                                <p>
                                    {{ $totalBookings }} Rides
                                </p>

                            </div>

                        </div>


                        <!-- Total Spent -->

                        <div class="col-md-4">

                            <div class="bntaxi-card">

                                <h6>
                                    Total Spent
                                </h6>

                                <p>
                                    £{{ number_format($totalSpent, 2) }}
                                </p>

                            </div>

                        </div>


                    </div>


                    <!-- =================================================
                         ACTION BUTTONS
                    ================================================== -->

                    <div class="mt-4">

                        <a
                            href="{{ url('/') }}"
                            class="btn btn-primary me-2">

                            Book Ride

                        </a>


                        <a
                            href="{{url('my-booking')}}"
                            class="btn btn-outline-primary">

                            View Bookings

                        </a>

                    </div>


                </div>

            </div>


        </div>

    </div>

</div>


@include('goods.include.footer')


</body>
</html>