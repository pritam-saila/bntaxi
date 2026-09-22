<!DOCTYPE html>
<html>
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
                <h5>Home // <a href="">Dashboard</a></h5>
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
                                    @include('goods.include.left-menu.php'); ?>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content account dashboard-content pl-50">
                                        <div class="tab-pane fade active show" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Account Details</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form method="post" name="https://nkmobile.org/herbal/user/account">
                                                        <input type="hidden" name="_token" value="M6xD42NU9wqPZq41XxmXPTxkMIaUuyh5MWyWMmU0" />
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label>New Password <span class="required">*</span></label>
                                                                <input required="" class="form-control" name="npassword" type="password" />
                                                            </div>
                                                            <div class="col-md-12">
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
