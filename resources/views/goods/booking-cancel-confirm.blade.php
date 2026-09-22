<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cancel Booking | BN Taxi Anytime</title>

    @include('goods.include.assets')

    <style>
        .bcc-wrap { background: #f4f7fb; padding: 45px 0 70px; }
        .bcc-card { max-width: 620px; margin: 0 auto; background: #fff; border: 1px solid #e6edf4;
                    border-radius: 16px; overflow: hidden; box-shadow: 0 14px 40px rgba(20,50,90,.08); }
        .bcc-head { background: #b02a37; color: #fff; padding: 26px 26px; text-align: center; }
        .bcc-head h1 { margin: 0; font-size: 21px; font-weight: 800; }
        .bcc-body { padding: 26px 28px 30px; }
        .bcc-alert { background: #f8d7da; color: #721c24; border: 1px solid #f1b0b7; border-radius: 8px;
                     padding: 12px 14px; font-size: 13px; margin-bottom: 18px; }
        .bcc-ok { background: #d4edda; color: #155724; border: 1px solid #b7dfc0; border-radius: 8px;
                  padding: 12px 14px; font-size: 13px; margin-bottom: 18px; }
        table.bcc-tbl { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        table.bcc-tbl th { text-align: left; width: 42%; padding: 9px 10px; font-size: 12.5px; font-weight: 700;
                           color: #53657d; background: #fbfcfe; border-bottom: 1px solid #edf1f5; }
        table.bcc-tbl td { padding: 9px 10px; font-size: 12.5px; color: #223; border-bottom: 1px solid #edf1f5; }
        .bcc-refund { font-size: 12.5px; color: #55657a; line-height: 1.6; margin-bottom: 20px; }
        .bcc-actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .bcc-btn { flex: 1 1 auto; text-align: center; padding: 12px 16px; border-radius: 9px; font-size: 13px;
                   font-weight: 700; text-decoration: none; border: 0; cursor: pointer; }
        .bcc-btn.keep { background: #0b3c5d; color: #fff; }
        .bcc-btn.cancel { background: #b02a37; color: #fff; }
        @media (max-width: 560px){ .bcc-btn{ flex: 1 1 100%; } }
    </style>
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
