<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>BN Taxi Anytime | User Account</title>

    @include('goods.include.assets')

    <style>

        /* =========================================================
           BN TAXI USER DASHBOARD
           PREMIUM / HEAVY RESPONSIVE DESIGN
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f3f7fc;
        }


        /* =========================================================
           DASHBOARD BACKGROUND
        ========================================================= */

        .bntaxi-dashboard {
            position: relative;

            min-height: 650px;

            padding: 45px 0 75px;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at 5% 10%,
                    rgba(18, 126, 245, 0.10),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 95% 90%,
                    rgba(0, 190, 255, 0.08),
                    transparent 30%
                ),
                #f4f7fb;
        }


        /* Decorative circles */

        .bntaxi-dashboard::before {
            content: "";

            position: absolute;

            width: 320px;
            height: 320px;

            right: -180px;
            top: -160px;

            border-radius: 50%;

            background: rgba(20, 126, 245, 0.06);

            pointer-events: none;
        }

        .bntaxi-dashboard::after {
            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            left: -150px;
            bottom: -130px;

            border-radius: 50%;

            background: rgba(0, 170, 255, 0.05);

            pointer-events: none;
        }


        /* =========================================================
           CONTAINER
        ========================================================= */

        .bntaxi-dashboard .container {
            position: relative;

            z-index: 2;

            max-width: 1180px;
        }


        /* =========================================================
           ROW
        ========================================================= */

        .bntaxi-dashboard .row {
            align-items: stretch;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .bntaxi-sidebar {
            position: relative;

            background:
                linear-gradient(
                    150deg,
                    #092943 0%,
                    #0b355b 55%,
                    #064c83 100%
                );

            border-radius: 20px;

            padding: 20px 15px;

            min-height: 365px;

            box-shadow:
                0 18px 40px rgba(10, 48, 85, 0.20);

            overflow: hidden;
        }


        /* Sidebar glow */

        .bntaxi-sidebar::before {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            right: -90px;
            top: -90px;

            border-radius: 50%;

            background: rgba(31, 139, 255, 0.18);

            pointer-events: none;
        }

        .bntaxi-sidebar::after {
            content: "";

            position: absolute;

            width: 150px;
            height: 150px;

            left: -90px;
            bottom: -80px;

            border-radius: 50%;

            background: rgba(0, 210, 255, 0.08);

            pointer-events: none;
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .bntaxi-main {
            position: relative;

            min-height: 365px;

            padding: 30px;

            background: rgba(255, 255, 255, 0.96);

            border: 1px solid #e6edf5;

            border-radius: 20px;

            box-shadow:
                0 15px 40px rgba(25, 60, 95, 0.08);

            overflow: hidden;
        }


        /* =========================================================
           TITLE
        ========================================================= */

        .bntaxi-main h4 {
            position: relative;

            margin: 0 0 25px;

            color: #123456;

            font-size: 27px;

            font-weight: 700;

            letter-spacing: -0.3px;
        }

        .bntaxi-main h4::after {
            content: "";

            display: block;

            width: 50px;
            height: 4px;

            margin-top: 9px;

            border-radius: 10px;

            background:
                linear-gradient(
                    90deg,
                    #087df5,
                    #3aa8ff
                );
        }


        /* =========================================================
           STAT CARDS
        ========================================================= */

        .bntaxi-card {
            position: relative;

            min-height: 112px;

            padding: 20px;

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #f7faff
                );

            border: 1px solid #e7edf5;

            border-radius: 15px;

            box-shadow:
                0 8px 22px rgba(20, 60, 100, 0.06);

            overflow: hidden;

            transition: all .3s ease;
        }


        /* Card top line */

        .bntaxi-card::before {
            content: "";

            position: absolute;

            left: 0;
            top: 0;

            width: 100%;
            height: 4px;

            background:
                linear-gradient(
                    90deg,
                    #0b7df4,
                    #45aaff
                );
        }


        /* Decorative circle */

        .bntaxi-card::after {
            content: "";

            position: absolute;

            width: 75px;
            height: 75px;

            right: -30px;
            bottom: -35px;

            border-radius: 50%;

            background: rgba(20, 126, 245, 0.06);
        }


        .bntaxi-card:hover {
            transform: translateY(-5px);

            box-shadow:
                0 15px 30px rgba(20, 60, 100, 0.10);

            border-color: #d8e8f8;
        }


        /* Card title */

        .bntaxi-card h6 {
            position: relative;

            z-index: 2;

            margin: 0 0 10px;

            color: #64748b;

            font-size: 13px;

            font-weight: 600;

            letter-spacing: .2px;
        }


        /* Card value */

        .bntaxi-card p {
            position: relative;

            z-index: 2;

            margin: 0;

            color: #173b61;

            font-size: 17px;

            font-weight: 700;
        }


        /* =========================================================
           ACTION AREA
        ========================================================= */

        .bntaxi-main .mt-4 {
            margin-top: 25px !important;

            display: flex;

            align-items: center;

            gap: 10px;
        }


        /* =========================================================
           BOOK RIDE
        ========================================================= */

        .bntaxi-main .btn-primary {
            min-height: 44px;

            padding: 10px 20px;

            border: 0;

            border-radius: 9px;

            background:
                linear-gradient(
                    135deg,
                    #1684ff,
                    #0065d8
                );

            color: #fff;

            font-size: 13px;

            font-weight: 700;

            box-shadow:
                0 8px 18px rgba(0, 105, 220, 0.22);

            transition: all .25s ease;
        }


        .bntaxi-main .btn-primary:hover {
            color: #fff;

            transform: translateY(-2px);

            box-shadow:
                0 12px 24px rgba(0, 105, 220, 0.28);
        }


        /* =========================================================
           VIEW BOOKINGS
        ========================================================= */

        .bntaxi-main .btn-outline-primary {
            min-height: 44px;

            padding: 9px 19px;

            border: 1px solid #1681f5;

            border-radius: 9px;

            background: #fff;

            color: #0875e5;

            font-size: 13px;

            font-weight: 600;

            transition: all .25s ease;
        }


        .bntaxi-main .btn-outline-primary:hover {
            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #1684ff,
                    #0065d8
                );

            border-color: #1684ff;

            transform: translateY(-2px);

            box-shadow:
                0 8px 18px rgba(0, 105, 220, 0.20);
        }


        /* =========================================================
           DESKTOP
        ========================================================= */

        @media (min-width: 1200px) {

            .bntaxi-dashboard {
                padding-top: 48px;
            }

            .bntaxi-main {
                padding: 32px;
            }

            .bntaxi-card {
                padding: 22px;
            }

        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 991px) {

            .bntaxi-dashboard {
                padding: 30px 0 60px;
            }

            .bntaxi-sidebar {
                min-height: auto;

                margin-bottom: 20px;
            }

            .bntaxi-main {
                min-height: auto;

                padding: 25px;
            }

            .bntaxi-main h4 {
                font-size: 24px;
            }

        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 767px) {

            .bntaxi-dashboard {
                width: 100%;

                min-height: auto;

                padding: 18px 9px 55px;

                overflow-x: hidden;
            }


            .bntaxi-dashboard .container {
                width: 100%;

                max-width: 100%;

                padding-left: 0;
                padding-right: 0;
            }


            .bntaxi-dashboard .row {
                width: 100%;

                margin-left: 0;
                margin-right: 0;
            }


            /* Sidebar */

            .bntaxi-sidebar {
                width: 100%;

                min-height: auto;

                margin-bottom: 18px;

                padding: 13px;

                border-radius: 18px;
            }


            /* Main */

            .bntaxi-main {
                width: 100%;

                min-height: auto;

                padding: 20px 14px;

                border-radius: 18px;
            }


            /* Title */

            .bntaxi-main h4 {
                margin-bottom: 20px;

                font-size: 23px;

                line-height: 1.2;
            }


            .bntaxi-main h4::after {
                width: 45px;

                height: 3px;

                margin-top: 8px;
            }


            /* Stat cards */

            .bntaxi-main .row.g-3 {
                margin-left: -5px;
                margin-right: -5px;
            }


            .bntaxi-main .row.g-3 > div {
                padding-left: 5px;
                padding-right: 5px;
            }


            .bntaxi-card {
                min-height: 105px;

                padding: 17px;

                border-radius: 14px;
            }


            .bntaxi-card h6 {
                font-size: 12px;
            }


            .bntaxi-card p {
                font-size: 16px;
            }


            /* Buttons */

            .bntaxi-main .mt-4 {
                margin-top: 20px !important;

                display: grid;

                grid-template-columns: 1fr 1fr;

                gap: 9px;
            }


            .bntaxi-main .btn-primary,
            .bntaxi-main .btn-outline-primary {
                width: 100%;

                min-height: 46px;

                padding: 10px 8px;

                margin: 0 !important;

                font-size: 12px;
            }

        }


        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 480px) {

            .bntaxi-dashboard {
                padding: 14px 7px 50px;
            }


            .bntaxi-sidebar {
                padding: 11px;

                border-radius: 16px;
            }


            .bntaxi-main {
                padding: 18px 12px;

                border-radius: 16px;
            }


            .bntaxi-main h4 {
                font-size: 21px;

                margin-bottom: 18px;
            }


            .bntaxi-card {
                min-height: 100px;

                padding: 15px;
            }


            .bntaxi-card h6 {
                font-size: 11px;
            }


            .bntaxi-card p {
                font-size: 14px;
            }


            .bntaxi-main .mt-4 {
                grid-template-columns: 1fr;

                gap: 8px;
            }


            .bntaxi-main .btn-primary,
            .bntaxi-main .btn-outline-primary {
                min-height: 45px;

                font-size: 13px;
            }

        }


    </style>
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