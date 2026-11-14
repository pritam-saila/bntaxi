<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cancel Booking | BN Taxi Anytime</title>

    @include('goods.include.assets')

    @stylesheet('goods/css/pages/booking-cancel-confirm.css')
</head>
<body>
@include('goods.include.header')

<div class="bcc-wrap">
    <div class="bcc-card">
        <div class="bcc-head">
            <h1>Cancel booking {{ $booking->booking_id }}</h1>
        </div>
        <div class="bcc-body">

            @if(session('error'))
                <div class="bcc-alert">{{ session('error') }}</div>
            @endif

            @if(! $booking->isCancellable())
                <div class="bcc-alert">
                    This booking is <strong>{{ $booking->status }}</strong> and can no longer be cancelled online.
                    Please <a href="{{ url('/contact') }}">contact us</a> if you need help.
                </div>
                <div class="bcc-actions">
                    <a href="{{ $booking->confirmationUrl() }}" class="bcc-btn keep">Back to booking</a>
                </div>
            @else
                <p style="font-size:14px;color:#333;">Please confirm you want to cancel the following journey:</p>

                <table class="bcc-tbl">
                    <tr><th>Pickup</th><td>{{ $booking->pickup }}</td></tr>
                    <tr><th>Destination</th><td>{{ $booking->dropoff }}</td></tr>
                    <tr><th>Pickup date &amp; time</th><td>{{ $booking->pickup_date }} {{ $booking->pickup_time }}</td></tr>
                    <tr><th>Total fare</th><td>£{{ number_format((float) $booking->price, 2) }}</td></tr>
                    <tr><th>Payment status</th><td>{{ $booking->payment_status_label }}</td></tr>
                </table>

                <p class="bcc-refund">
                    @if($booking->isOnlinePayment() && $booking->isPaid())
                        If you paid online, any refund due will be calculated from our cancellation policy
                        based on how far in advance you are cancelling, and processed to your original
                        payment method (or flagged for manual processing).
                    @else
                        There is nothing to refund for this booking as no online payment has been taken.
                    @endif
                </p>

                <form method="POST" action="{{ route('booking.cancel.perform', $booking->access_token) }}">
                    @csrf
                    <div style="margin-bottom:16px;">
                        <label style="font-size:12.5px;font-weight:700;color:#53657d;display:block;margin-bottom:6px;">
                            Reason for cancelling (optional)
                        </label>
                        <textarea name="cancellation_reason" rows="3" maxlength="1000"
                                  style="width:100%;border:1px solid #cfdcea;border-radius:8px;padding:10px;font-size:13px;"
                                  placeholder="Let us know why you are cancelling (optional)"></textarea>
                    </div>
                    <div class="bcc-actions">
                        <a href="{{ $booking->confirmationUrl() }}" class="bcc-btn keep">Keep my booking</a>
                        <button type="submit" class="bcc-btn cancel"
                                onclick="return confirm('Are you sure you want to cancel this booking?');">
                            Yes, cancel booking
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>

@include('goods.include.footer')
</body>
</html>
