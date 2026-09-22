<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Booking Confirmation | BN Taxi Anytime</title>

    @include('goods.include.assets')

    <style>
        .bnc-wrap { background: #f4f7fb; padding: 45px 0 70px; }
        .bnc-card { max-width: 760px; margin: 0 auto; background: #fff; border: 1px solid #e6edf4;
                    border-radius: 16px; overflow: hidden; box-shadow: 0 14px 40px rgba(20,50,90,.08); }
        .bnc-hero { background: linear-gradient(135deg,#0b3c5d,#0a4b83); color: #fff; padding: 34px 28px; text-align: center; }
        .bnc-hero .tick { width: 64px; height: 64px; border-radius: 50%; background: rgba(255,255,255,.16);
                          display: inline-flex; align-items: center; justify-content: center; font-size: 30px; margin-bottom: 12px; }
        .bnc-hero h1 { margin: 0; font-size: 24px; font-weight: 800; }
        .bnc-hero p { margin: 8px 0 0; font-size: 13px; opacity: .9; }
        .bnc-ref { text-align: center; margin: -22px 22px 0; position: relative; background: #eaf3ff;
                   border: 1px dashed #9cc4ee; border-radius: 12px; padding: 16px; }
        .bnc-ref .label { font-size: 11px; text-transform: uppercase; letter-spacing: .6px; color: #55708c; font-weight: 700; }
        .bnc-ref .value { font-size: 24px; font-weight: 800; color: #0b3c5d; margin-top: 3px; }
        .bnc-body { padding: 26px 28px 30px; }
        .bnc-status { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 11px;
                     font-weight: 800; text-transform: uppercase; letter-spacing: .4px; }
        .bnc-status.pending { background: #fff3cd; color: #856404; }
        .bnc-status.confirmed { background: #d4edda; color: #155724; }
        .bnc-status.cancelled, .bnc-status.rejected { background: #f8d7da; color: #721c24; }
        .bnc-note { margin: 14px 0 22px; font-size: 13px; color: #55657a; line-height: 1.6; }
        .bnc-sec { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: .5px;
                   color: #0b3c5d; border-bottom: 2px solid #eef2f6; padding-bottom: 7px; margin: 24px 0 12px; }
        table.bnc-tbl { width: 100%; border-collapse: collapse; }
        table.bnc-tbl th { text-align: left; width: 40%; padding: 10px; font-size: 12.5px; font-weight: 700;
                           color: #53657d; background: #fbfcfe; border-bottom: 1px solid #edf1f5; }
        table.bnc-tbl td { padding: 10px; font-size: 12.5px; color: #223; border-bottom: 1px solid #edf1f5; }
        .bnc-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 26px; }
        .bnc-btn { flex: 1 1 auto; text-align: center; padding: 12px 16px; border-radius: 9px; font-size: 13px;
                   font-weight: 700; text-decoration: none; white-space: nowrap; }
        .bnc-btn.primary { background: #0b3c5d; color: #fff; }
        .bnc-btn.blue { background: #3a6ea5; color: #fff; }
        .bnc-btn.ghost { background: #fff; color: #0b3c5d; border: 1px solid #cfdcea; }
        .bnc-btn.danger { background: #fff; color: #b02a37; border: 1px solid #b02a37; }
        .bnc-help { margin-top: 20px; font-size: 12.5px; color: #6b7a8d; text-align: center; }
        @media (max-width: 600px){ .bnc-btn{ flex: 1 1 100%; } }
    </style>
</head>
<body>
@include('goods.include.header')

<div class="bnc-wrap">
    <div class="bnc-card">
        <div class="bnc-hero">
            <div class="tick">&#10003;</div>
            <h1>Thank you, {{ $booking->name }}</h1>
            <p>Your booking request has been received.</p>
        </div>

        <div class="bnc-ref">
            <div class="label">Your booking reference</div>
            <div class="value">{{ $booking->booking_id }}</div>
        </div>

        <div class="bnc-body">
            @php
                $statusClass = match($booking->status) {
                    'CONFIRMED' => 'confirmed',
                    'CANCELLED' => 'cancelled',
                    'REJECTED'  => 'rejected',
                    default     => 'pending',
                };
            @endphp
            <span class="bnc-status {{ $statusClass }}">{{ $booking->status }}</span>

            <p class="bnc-note">
                @if($booking->status === 'PENDING APPROVAL')
                    We are checking driver availability now. Your journey is confirmed only once BN Taxi
                    sends you a confirmation email. A copy of these details and a PDF receipt have been
                    emailed to <strong>{{ $booking->email }}</strong>.
                @elseif($booking->status === 'CONFIRMED')
                    Your journey is confirmed. See you at your pickup time.
                @elseif(in_array($booking->status, ['CANCELLED', 'REJECTED']))
                    This booking is no longer active. If you believe this is a mistake, please contact us.
                @else
                    A copy of these details and a PDF receipt have been emailed to <strong>{{ $booking->email }}</strong>.
                @endif
            </p>

            <div class="bnc-sec">Journey</div>
            <table class="bnc-tbl">
                <tr><th>Pickup date &amp; time</th><td><strong>{{ $booking->pickup_date }}</strong> at <strong>{{ $booking->pickup_time }}</strong></td></tr>
                @if($booking->is_return)
                    <tr><th>Return date &amp; time</th><td>{{ $booking->return_date }} at {{ $booking->return_time }}</td></tr>
                @endif
                <tr><th>Pickup address</th><td>{{ $booking->pickup }}</td></tr>
                @if(is_array($booking->vias) && count($booking->vias) > 2)
                    <tr><th>Stops (via)</th><td>
                        @foreach($booking->vias as $i => $via)
                            @if($i > 0 && $i < count($booking->vias) - 1)&bull; {{ $via }}<br>@endif
                        @endforeach
                    </td></tr>
                @endif
                <tr><th>Destination</th><td>{{ $booking->dropoff }}</td></tr>
                <tr><th>Vehicle</th><td>{{ optional($booking->carDetail)->name ?? 'To be assigned' }}</td></tr>
                <tr><th>Passengers</th><td>{{ $booking->passengers ?? 1 }}</td></tr>
                <tr><th>Bags</th><td>{{ $booking->bags ?? 0 }}</td></tr>
                @if($booking->distance)
                    <tr><th>Estimated distance</th><td>{{ number_format((float) $booking->distance, 1) }} miles</td></tr>
                @endif
                @if(!empty($booking->special_instructions))
                    <tr><th>Special instructions</th><td>{{ $booking->special_instructions }}</td></tr>
                @endif
            </table>

            @if(!empty($booking->flight_number))
                <div class="bnc-sec">Flight</div>
                <table class="bnc-tbl">
                    <tr><th>Flight number</th><td>{{ $booking->flight_number }}</td></tr>
                    <tr><th>Airline</th><td>{{ $booking->airline ?? 'N/A' }}</td></tr>
                    <tr><th>Airport</th><td>{{ $booking->flight_airport ?? 'N/A' }}</td></tr>
                    <tr><th>Direction</th><td>{{ $booking->flight_direction ?? 'N/A' }}</td></tr>
                    <tr><th>Scheduled time</th><td>{{ $booking->flight_scheduled_time ?? 'N/A' }}</td></tr>
                </table>
            @endif

            <div class="bnc-sec">Fare &amp; Payment</div>
            <table class="bnc-tbl">
                <tr><th>Total price</th><td><strong style="color:#0b3c5d;font-size:15px;">£{{ number_format((float) $booking->price, 2) }}</strong></td></tr>
                <tr><th>Payment method</th><td>{{ $booking->payment_method_display }}</td></tr>
                <tr><th>Payment status</th><td>{{ $booking->payment_status_label }}</td></tr>
                @if((float) $booking->amount_paid > 0 && $booking->outstandingBalance() > 0)
                    <tr><th>Amount paid</th><td>£{{ number_format((float) $booking->amount_paid, 2) }}</td></tr>
                    <tr><th>Outstanding balance</th><td>£{{ number_format($booking->outstandingBalance(), 2) }}</td></tr>
                @endif
            </table>

            <div class="bnc-actions">
                <a href="{{ $booking->receiptUrl() }}" class="bnc-btn primary" target="_blank" rel="noopener">Download receipt (PDF)</a>
                <a href="{{ url('/contact') }}" class="bnc-btn blue">Contact us</a>
                @auth
                    <a href="{{ url('/my-booking') }}" class="bnc-btn ghost">My bookings</a>
                @endauth
                @if($booking->isCancellable())
                    <a href="{{ $booking->cancelUrl() }}" class="bnc-btn danger">Cancel this booking</a>
                @endif
            </div>

            <p class="bnc-help">
                Need help? Call <a href="tel:+441273757373">+44 1273 757373</a> or
                <a href="{{ url('/contact') }}">contact us online</a>.
            </p>
        </div>
    </div>
</div>

@include('goods.include.footer')
</body>
</html>
