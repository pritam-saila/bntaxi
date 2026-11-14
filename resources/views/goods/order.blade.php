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
                <h5>Home // <a href="">Order</a></h5>
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
                                        <div class="tab-pane fade active show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="mb-0">Your Orders</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Order</th>
                                                                    <th>Date</th>
                                                                    <th>payment option</th>
                                                                    <th>Collection</th>
                                                                    <th>Delivery</th>
                                                                </tr>
                                                                @foreach ($booking as $item)
                                                                    
                                                                <tr>
                                                                    <td>{{$item->booking_id}}</td>
                                                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                                    <td>Paid</td>
                                                                    <td>
                                                                        <p>{{$item->collectdate}}</p>
                                                                        <p>{{$item->collectby}}</p>
                                                                        <p>{{$item->collecttime}}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{$item->deliverydate}}</p>
                                                                        <p>{{$item->deliveryby}}</p>
                                                                        <p>{{$item->deliverytime}}</p>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
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
            </div>
        </main>

        @include('goods.include.footer')

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
    </body>
</html>
