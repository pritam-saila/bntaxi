<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BN Taxi Anytime</title>

    @include('goods.include.assets')

    @stylesheet('goods/css/pages/my-profile.css')
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