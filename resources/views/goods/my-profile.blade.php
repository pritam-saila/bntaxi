<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BN Taxi Anytime</title>

    @include('goods.include.assets')

    <style>

        /* =========================================================
           BN TAXI - MY PROFILE
           PREMIUM / PROFESSIONAL DESIGN
        ========================================================= */

        .bntaxi-profile-page {
            background:
                radial-gradient(
                    circle at 5% 10%,
                    rgba(22, 126, 245, 0.08),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 95% 90%,
                    rgba(0, 181, 255, 0.07),
                    transparent 30%
                ),
                #f4f7fb;
        }


        /* =========================================================
           PAGE TITLE
        ========================================================= */

        .bntaxi-main > h3 {
            color: #123456;

            font-size: 28px;
            font-weight: 700;

            letter-spacing: -0.3px;

            margin-bottom: 25px !important;
        }

        .bntaxi-main > h3::after {
            content: "";

            display: block;

            width: 50px;
            height: 4px;

            margin-top: 9px;

            background: linear-gradient(
                90deg,
                #087bf5,
                #35a7ff
            );

            border-radius: 10px;
        }


        /* =========================================================
           PROFILE CARDS
        ========================================================= */

        .bntaxi-profile-card {
            position: relative;

            background: #fff;

            border-radius: 20px;

            border: 1px solid #e8edf4;

            box-shadow:
                0 15px 40px rgba(17, 52, 87, 0.08),
                0 3px 10px rgba(17, 52, 87, 0.04);

            overflow: hidden;

            transition: all 0.3s ease;
        }

        .bntaxi-profile-card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 20px 45px rgba(17, 52, 87, 0.12);
        }


        /* =========================================================
           PROFILE CARD TOP DESIGN
        ========================================================= */

        .bntaxi-profile-card::before {
            content: "";

            position: absolute;

            left: 0;
            top: 0;

            width: 100%;
            height: 75px;

            background: linear-gradient(
                135deg,
                #082c54 0%,
                #07518c 55%,
                #1688f5 100%
            );
        }


        /* =========================================================
           PROFILE INFO CARD
        ========================================================= */

        .bntaxi-profile-info {
            position: relative;

            z-index: 2;

            padding: 35px 25px 30px;

            text-align: center;
        }


        /* =========================================================
           PROFILE AVATAR
        ========================================================= */

        .bntaxi-profile-avatar-wrap {
            position: relative;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: 124px;
            height: 124px;

            margin-bottom: 17px;

            padding: 6px;

            background: #fff;

            border-radius: 50%;

            box-shadow:
                0 10px 30px rgba(0, 55, 110, 0.22);
        }

        .bntaxi-profile-avatar {
            display: block;

            width: 100px !important;
            height: 100px !important;

            object-fit: cover;

            border-radius: 50% !important;

            border: 4px solid #eaf4ff;

            background: #eef5fc;
        }


        /* =========================================================
           PROFILE USER ICON / FALLBACK
        ========================================================= */

        .bntaxi-profile-avatar-wrap::after {
            content: "";

            position: absolute;

            right: 2px;
            bottom: 8px;

            width: 25px;
            height: 25px;

            background: #18a957;

            border: 4px solid #fff;

            border-radius: 50%;
        }


        /* =========================================================
           USER NAME
        ========================================================= */

        .bntaxi-profile-info h5 {
            margin: 3px 0 7px;

            color: #123456;

            font-size: 21px;
            font-weight: 700;
        }

        .bntaxi-profile-email {
            margin-bottom: 20px;

            color: #718096;

            font-size: 13px;
            font-weight: 500;

            word-break: break-word;
        }


        /* =========================================================
           CHANGE PHOTO BUTTON
        ========================================================= */

        .bntaxi-change-photo {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-height: 42px;

            padding: 9px 18px;

            border: 1px solid #147df5;

            border-radius: 9px;

            background: #fff;

            color: #1475df;

            font-size: 13px;
            font-weight: 600;

            transition: all 0.25s ease;

            cursor: pointer;
        }

        .bntaxi-change-photo:hover {
            color: #fff;

            background: linear-gradient(
                135deg,
                #1683ff,
                #0065d8
            );

            border-color: #1683ff;

            box-shadow:
                0 8px 20px rgba(0, 115, 230, 0.22);

            transform: translateY(-2px);
        }


        /* =========================================================
           EDIT PROFILE CARD
        ========================================================= */

        .bntaxi-edit-card {
            padding: 30px;
        }

        .bntaxi-edit-card h5 {
            position: relative;

            margin-bottom: 25px;

            padding-bottom: 14px;

            color: #fff;

            font-size: 21px;
            font-weight: 700;

            border-bottom: 1px solid #edf0f4;
        }

        .bntaxi-edit-card h5::after {
            content: "";

            position: absolute;

            left: 0;
            bottom: -1px;

            width: 42px;
            height: 3px;

            background: #147df5;

            border-radius: 10px;
        }


        /* =========================================================
           FORM LABEL
        ========================================================= */

        .bntaxi-edit-card label {
            display: block;

            margin-bottom: 8px;

            color: #263f5b;

            font-size: 13px;
            font-weight: 700;
        }


        /* =========================================================
           FORM INPUT
        ========================================================= */

        .bntaxi-edit-card .form-control {
            min-height: 48px;

            padding: 10px 14px;

            color: #263f5b;

            background: #fff;

            border: 1px solid #dce4ed;

            border-radius: 9px;

            font-size: 14px;

            box-shadow: none;

            transition: all 0.25s ease;
        }

        .bntaxi-edit-card .form-control:focus {
            color: #263f5b;

            background: #fff;

            border-color: #1683f5;

            box-shadow:
                0 0 0 4px rgba(22, 131, 245, 0.10);
        }


        /* Readonly email */

        .bntaxi-edit-card input[readonly] {
            background: #f0f3f7;

            color: #64748b;

            cursor: not-allowed;
        }


        /* Textarea */

        .bntaxi-edit-card textarea.form-control {
            min-height: 105px;

            resize: vertical;

            line-height: 1.5;
        }


        /* =========================================================
           UPDATE BUTTON
        ========================================================= */

        .bntaxi-update-btn {
            min-height: 48px;

            padding: 10px 22px;

            border: 0;

            border-radius: 9px;

            background: linear-gradient(
                135deg,
                #1684ff,
                #0065d7
            );

            color: #fff;

            font-size: 14px;
            font-weight: 700;

            box-shadow:
                0 8px 20px rgba(0, 105, 220, 0.22);

            transition: all 0.25s ease;
        }

        .bntaxi-update-btn:hover {
            color: #fff;

            background: linear-gradient(
                135deg,
                #006fe8,
                #0055b8
            );

            transform: translateY(-2px);

            box-shadow:
                0 12px 25px rgba(0, 105, 220, 0.28);
        }


        /* =========================================================
           SUCCESS / ERROR ALERT
        ========================================================= */

        .bntaxi-profile-alert {
            border: 0;

            border-radius: 11px;

            padding: 14px 17px;

            font-size: 13px;
            font-weight: 600;

            box-shadow:
                0 7px 20px rgba(0, 0, 0, 0.05);
        }

        .bntaxi-profile-alert.alert-success {
            color: #08783b;

            background: #eafaf1;

            border-left: 4px solid #17a957;
        }

        .bntaxi-profile-alert.alert-danger {
            color: #b42332;

            background: #fff0f1;

            border-left: 4px solid #e5394f;
        }


        /* =========================================================
           DESKTOP
        ========================================================= */

        @media (min-width: 992px) {

            .bntaxi-profile-page {
                padding-top: 50px;
                padding-bottom: 80px;
            }

            .bntaxi-profile-info {
                min-height: 355px;
            }

            .bntaxi-edit-card {
                min-height: 355px;
            }

        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 991px) {

            .bntaxi-profile-page {
                padding-top: 35px;
                padding-bottom: 60px;
            }

            .bntaxi-profile-card {
                border-radius: 17px;
            }

            .bntaxi-edit-card {
                padding: 25px;
            }

        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 767px) {

            .bntaxi-profile-page {
                padding: 20px 10px 55px;
            }

            .bntaxi-profile-page .container {
                width: 100%;

                padding-left: 0;
                padding-right: 0;
            }


            /* Sidebar */

            .bntaxi-profile-page .bntaxi-sidebar {
                width: 100%;

                margin-bottom: 18px;
            }


            /* Main */

            .bntaxi-profile-page .bntaxi-main {
                width: 100%;
            }


            /* Title */

            .bntaxi-main > h3 {
                margin-left: 3px;

                margin-bottom: 18px !important;

                font-size: 23px;
            }

            .bntaxi-main > h3::after {
                width: 42px;
                height: 3px;
            }


            /* Profile card */

            .bntaxi-profile-card {
                border-radius: 16px;

                margin-bottom: 0;
            }


            .bntaxi-profile-info {
                padding: 32px 20px 25px;
            }


            /* Avatar */

            .bntaxi-profile-avatar-wrap {
                width: 112px;
                height: 112px;
            }

            .bntaxi-profile-avatar {
                width: 90px !important;
                height: 90px !important;
            }


            .bntaxi-profile-info h5 {
                font-size: 19px;
            }


            /* Edit */

            .bntaxi-edit-card {
                padding: 22px 18px;
            }

            .bntaxi-edit-card h5 {
                font-size: 19px;

                margin-bottom: 20px;
            }


            /* Form */

            .bntaxi-edit-card .form-control {
                min-height: 47px;

                font-size: 14px;
            }


            /* Update */

            .bntaxi-update-btn {
                width: 100%;

                min-height: 48px;
            }

        }


        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 480px) {

            .bntaxi-profile-page {
                padding: 15px 8px 50px;
            }

            .bntaxi-main > h3 {
                font-size: 21px;
            }

            .bntaxi-profile-info {
                padding: 28px 15px 22px;
            }

            .bntaxi-edit-card {
                padding: 20px 14px;
            }

            .bntaxi-edit-card h5 {
                font-size: 18px;
            }

            .bntaxi-edit-card label {
                font-size: 12px;
            }

            .bntaxi-edit-card .form-control {
                font-size: 13px;
            }

        }

    </style>
</head>


<body>

    @include('goods.include.header')


    <!-- =========================================================
         PROFILE PAGE
    ========================================================== -->

    <div class="bntaxi-dashboard bntaxi-profile-page">

        <div class="container mt-4">

            <div class="row">


                <!-- =================================================
                     SIDEBAR
                ================================================== -->

                <div class="col-md-3 bntaxi-sidebar">

                    @include('goods.include.dashboad-menu')

                </div>


                <!-- =================================================
                     MAIN CONTENT
                ================================================== -->

                <div class="col-md-9 bntaxi-main">

                    <h3 class="mb-4">
                        My Profile
                    </h3>


                    <!-- SUCCESS MESSAGE -->

                    @if(session()->has('success'))

                        <div
                            class="alert alert-success mb-3 alert-dismissible fade show bntaxi-profile-alert"
                            role="alert">

                            {{ session()->get('success') }}

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                            </button>

                        </div>

                    @endif


                    <!-- ERROR MESSAGE -->

                    @if(session()->has('error'))

                        <div
                            class="alert alert-danger mb-3 alert-dismissible fade show bntaxi-profile-alert"
                            role="alert">

                            {{ session()->get('error') }}

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                            </button>

                        </div>

                    @endif


                    <!-- =================================================
                         PROFILE FORM
                    ================================================== -->

                    <form
                        action="{{ route('user.update') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf


                        <div class="row g-4">


                            <!-- =================================================
                                 LEFT PROFILE CARD
                            ================================================== -->

                            <div class="col-md-4">

                                <div class="bntaxi-profile-card">

                                    <div class="bntaxi-profile-info">


                                        <!-- PROFILE IMAGE -->

                                        <div class="bntaxi-profile-avatar-wrap">

                                            <img
                                                src="{{ auth()->user()->image ? url(Storage::url(auth()->user()->image)) : 'https://i.pravatar.cc/100' }}"
                                                id="profile-preview"
                                                class="bntaxi-avatar bntaxi-profile-avatar mb-3"
                                                style="object-fit: cover; width: 100px; height: 100px; border-radius: 50%;"
                                            />

                                        </div>


                                        <!-- USER NAME -->

                                        <h5>
                                            {{ auth()->user()->name }}
                                        </h5>


                                        <!-- USER EMAIL -->

                                        <p class="bntaxi-profile-email">
                                            {{ auth()->user()->email }}
                                        </p>


                                        <!-- CHANGE PHOTO -->

                                        <label
                                            class="bntaxi-change-photo"
                                            style="cursor: pointer;">

                                            Change Photo

                                            <input
                                                type="file"
                                                name="image"
                                                id="profile-image"
                                                style="display: none;"
                                                accept="image/*"
                                                onchange="previewImage(event)"
                                            />

                                        </label>

                                    </div>

                                </div>

                            </div>


                            <!-- =================================================
                                 RIGHT EDIT PROFILE
                            ================================================== -->

                            <div class="col-md-8">

                                <div class="bntaxi-profile-card bntaxi-edit-card">


                                    <h5>
                                        Edit Profile
                                    </h5>


                                    <!-- NAME + EMAIL -->

                                    <div class="row">


                                        <!-- FULL NAME -->

                                        <div class="col-md-6 mb-3">

                                            <label>
                                                Full Name
                                            </label>

                                            <input
                                                type="text"
                                                name="name"
                                                class="form-control"
                                                value="{{ auth()->user()->name }}"
                                                required
                                            />

                                        </div>


                                        <!-- EMAIL -->

                                        <div class="col-md-6 mb-3">

                                            <label>
                                                Email
                                            </label>

                                            <input
                                                type="email"
                                                name="email"
                                                class="form-control"
                                                value="{{ auth()->user()->email }}"
                                                readonly
                                            />

                                        </div>

                                    </div>


                                    <!-- PHONE -->

                                    <div class="row">

                                        <div class="col-md-12 mb-3">

                                            <label>
                                                Phone
                                            </label>

                                            <input
                                                type="text"
                                                name="phone"
                                                class="form-control"
                                                value="{{ auth()->user()->phone }}"
                                                required
                                            />

                                        </div>

                                    </div>


                                    <!-- ADDRESS -->

                                    <div class="mb-3">

                                        <label>
                                            Address
                                        </label>

                                        <textarea
                                            name="address"
                                            class="form-control"
                                            rows="3">{{ auth()->user()->address }}</textarea>

                                    </div>


                                    <!-- UPDATE -->

                                    <button
                                        type="submit"
                                        class="btn bntaxi-update-btn">

                                        Update Profile

                                    </button>


                                </div>

                            </div>


                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    @include('goods.include.footer')


    <!-- =========================================================
         IMAGE PREVIEW
    ========================================================== -->

    <script>

        function previewImage(event) {

            var reader = new FileReader();

            reader.onload = function() {

                var output =
                    document.getElementById('profile-preview');

                output.src = reader.result;

            };

            reader.readAsDataURL(
                event.target.files[0]
            );

        }

    </script>

</body>
</html>