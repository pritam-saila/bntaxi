<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BN Taxi Anytime | Change Password</title>

    @include('goods.include.assets')

    @stylesheet('goods/css/pages/change-password.css')
</head>


<body>

    @include('goods.include.header')


    <!-- =========================================================
         CHANGE PASSWORD PAGE
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
                        Change Password
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
                         PASSWORD FORM
                    ================================================== -->

                    <form
                        action="{{ url('user-change-password') }}"
                        method="POST">

                        @csrf


                        <div class="row g-4">


                            <!-- =================================================
                                 RIGHT EDIT PROFILE
                            ================================================== -->

                            <div class="col-md-12">

                                <div class="bntaxi-profile-card bntaxi-edit-card">


                                    <h5>
                                        Update Password
                                    </h5>


                                    <!-- PASSWORD FIELDS -->

                                    <div class="row">


                                        <!-- NEW PASSWORD -->

                                        <div class="col-md-6 mb-3">

                                            <label>
                                                New Password <span class="text-danger">*</span>
                                            </label>

                                            <input
                                                type="password"
                                                name="newpass"
                                                class="form-control"
                                                placeholder="Enter new password"
                                                required
                                            />

                                        </div>


                                        <!-- CONFIRM PASSWORD -->

                                        <div class="col-md-6 mb-3">

                                            <label>
                                                Confirm New Password <span class="text-danger">*</span>
                                            </label>

                                            <input
                                                type="password"
                                                name="confirmpass"
                                                class="form-control"
                                                placeholder="Confirm new password"
                                                required
                                            />

                                        </div>

                                    </div>


                                    <!-- UPDATE BUTTON -->

                                    <button
                                        type="submit"
                                        class="btn bntaxi-update-btn mt-3">

                                        Save Change

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

</body>
</html>
