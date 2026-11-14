<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>

        @include('goods.include.assets')
    </head>
    <body>
        @include('goods.include.header')

        <div class="banners">
            <div class="banner-paras">
                <h1>Dashboard</h1>
                <h5>Home // <a href="">Account Details</a></h5>
            </div>
        </div>

        <div class="banner_bottom">
            <div class="container">
                <h2>Get a FREE Instant Quote Here <span>Get A Quote</span></h2>
            </div>
        </div>

        <main class="main pages">
            <div class="page-content pt-50 pb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 m-auto">
                            <div class="row">
                                <div class="col-md-3">
                                    @include('goods.include.left-menu')
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content account dashboard-content pl-50">
                                        <div class="tab-pane fade active show" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Account Details</h5>
                                                    @if(session()->has('success'))
                                        <div class="alert alert-success mb-0 alert-dismissible fade show" role="alert">
                                        {{ session()->get('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        @if(session()->has('error'))
                                        <div class="alert alert-danger mb-0 alert-dismissible fade show" role="alert">
                                        {{ session()->get('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                                </div>
                                                <div class="card-body">
                                                    <form method="post" action="{{route('user.update')}}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label>Name <span class="required">*</span></label>
                                                                <input required="" class="form-control" name="name" value="{{auth()->user()->name}}" type="text" />
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Phone <span class="required">*</span></label>
                                                                <input required="" class="form-control" name="phone" value="{{auth()->user()->phone}}" />
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Email Address <span class="required">*</span></label>
                                                                <input readonly="" class="form-control" name="email" value="{{auth()->user()->email}}" type="email" readonly/>
                                                            </div>
                                                            <div class="col-md-12" id="accounts">
                                                                <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('goods.include.footer')

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
    </body>
</html>
