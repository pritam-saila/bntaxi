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



<div class="bntaxi-dashboard">

    <div class="container mt-4">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2 bntaxi-sidebar">

                @include('goods.include.dashboad-menu')

            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 bntaxi-main">
 <h3 class="mb-4">Payments</h3>

 @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
 @endif

 @if(!$booking)
    <div class="alert alert-warning">No booking details found. Please <a href="{{ url('/') }}">start a new booking</a>.</div>
 @else
<div class="row g-4">

    <!-- LEFT: PAYMENT METHOD -->
    <div class="col-md-7">
        <div class="bntaxi-card">

            <h5 class="mb-3">Select Payment Method</h5>

            <!-- CARD -->
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="payment" checked>
                <label class="form-check-label">Credit / Debit Card</label>
            </div>

            <!-- CASH -->
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="payment">
                <label class="form-check-label">Cash</label>
            </div>

            <!-- WALLET -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="payment">
                <label class="form-check-label">Wallet (£120 Available)</label>
            </div>

            <!-- CARD FORM -->
            <div class="bntaxi-card-form">

                <input type="text" class="form-control mb-2" placeholder="Card Number">
                
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control mb-2" placeholder="MM/YY">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control mb-2" placeholder="CVV">
                    </div>
                </div>

                <input type="text" class="form-control" placeholder="Card Holder Name">

            </div>

        </div>
    </div>


    <!-- RIGHT: SUMMARY -->
    <div class="col-md-5">
        <div class="bntaxi-card">

            <h5 class="mb-3">Booking Summary</h5>

            <p><strong>Route:</strong> {{ $booking->pickup }} &rarr; {{ $booking->dropoff }}</p>
            <p><strong>Car:</strong> {{ $booking->carDetail->name ?? 'N/A' }}</p>

            <hr>

            <h5>Total: £{{ number_format($booking->price, 2) }}</h5>

            <form action="{{ route('stripe.post') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="name" value="Booking {{ $booking->booking_id }}">
                <input type="hidden" name="price" value="{{ $booking->price }}">
                <button type="submit" class="btn btn-success w-100 mt-3">Confirm Payment</button>
            </form>

        </div>
    </div>

</div>
@endif

            </div>

        </div>
    </div>

</div>
@include('goods.include.footer')
    </body>
</html>
