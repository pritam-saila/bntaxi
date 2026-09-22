<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BN Taxi - Booking Received</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,.05); }
        .header { background-color: #0b3c5d; padding: 30px 20px; text-align: center; color: #fff; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: .5px; }
        .status-banner { padding: 15px; text-align: center; font-weight: bold; font-size: 15px; text-transform: uppercase; background-color: #fff3cd; color: #856404; border-bottom: 2px solid #ffeeba; }
        .content { padding: 30px 25px; }
        .reference { text-align: center; background: #eaf3ff; border: 1px dashed #9cc4ee; border-radius: 10px; padding: 16px; margin-bottom: 22px; }
        .reference .label { font-size: 12px; text-transform: uppercase; letter-spacing: .5px; color: #55708c; }
        .reference .value { font-size: 22px; font-weight: 800; color: #0b3c5d; margin-top: 4px; }
        .section-title { font-size: 15px; font-weight: bold; color: #0b3c5d; border-bottom: 2px solid #eaeaea; padding-bottom: 8px; margin: 25px 0 15px; text-transform: uppercase; }
        .detail-table { width: 100%; border-collapse: collapse; }
        .detail-table th { text-align: left; padding: 10px; background-color: #f8f9fa; border-bottom: 1px solid #eee; width: 38%; font-weight: 600; font-size: 13px; }
        .detail-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 13px; }
        .btn-row { text-align: center; margin: 28px 0 8px; }
        .btn { display: inline-block; padding: 12px 22px; margin: 6px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; }
        .btn-primary { background: #0b3c5d; color: #fff; }
        .btn-danger { background: #fff; color: #b02a37; border: 1px solid #b02a37; }
        .attach-note { margin-top: 20px; padding: 12px 14px; background: #ecfdf3; border: 1px solid #b7ebc6; border-radius: 8px; font-size: 13px; color: #1c6b3d; }
        .footer { background-color: #f8f9fa; text-align: center; padding: 20px; font-size: 12px; color: #777; border-top: 1px solid #eee; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>BN TAXI BRIGHTON</h1>
    </div>

    <div class="status-banner">Booking Request Received</div>

    <div class="content">
        <p>Hi {{ $booking->name }},</p>
        <p>
            Thank you for booking with BN Taxi. We have received your request and it is currently
            <strong>PENDING APPROVAL</strong>. Your journey is confirmed only once we send you a
            separate confirmation email &mdash; we are checking availability now.
        </p>

        <div class="reference">
            <div class="label">Your booking reference</div>
            <div class="value">{{ $booking->booking_id }}</div>
        </div>

        <div class="section-title">Journey Details</div>
        <table class="detail-table">
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
            @if(!empty($booking->special_instructions))
                <tr><th>Special instructions</th><td>{{ $booking->special_instructions }}</td></tr>
            @endif
        </table>

        <div class="section-title">Fare &amp; Payment</div>
        <table class="detail-table">
            <tr><th>Total price</th><td><strong style="color:#0b3c5d;font-size:16px;">£{{ number_format((float) $booking->price, 2) }}</strong></td></tr>
            <tr><th>Payment method</th><td>{{ $booking->payment_method_display }}</td></tr>
            <tr><th>Payment status</th><td>{{ $booking->payment_status_label }}</td></tr>
            @if((float) $booking->amount_paid > 0 && $booking->outstandingBalance() > 0)
                <tr><th>Amount paid</th><td>£{{ number_format((float) $booking->amount_paid, 2) }}</td></tr>
                <tr><th>Outstanding balance</th><td>£{{ number_format($booking->outstandingBalance(), 2) }}</td></tr>
            @endif
        </table>

        @if(!empty($booking->flight_number))
            <div class="section-title">Flight Details</div>
            <table class="detail-table">
                <tr><th>Flight number</th><td>{{ $booking->flight_number }}</td></tr>
                <tr><th>Airline</th><td>{{ $booking->airline ?? 'N/A' }}</td></tr>
                <tr><th>Airport</th><td>{{ $booking->flight_airport ?? 'N/A' }}</td></tr>
                <tr><th>Direction</th><td>{{ $booking->flight_direction ?? 'N/A' }}</td></tr>
                <tr><th>Scheduled time</th><td>{{ $booking->flight_scheduled_time ?? 'N/A' }}</td></tr>
            </table>
        @endif

        <div class="btn-row">
            <a href="{{ $booking->confirmationUrl() }}" class="btn btn-primary">View booking online</a>
            <a href="{{ $booking->receiptUrl() }}" class="btn btn-primary" style="background:#16a34a;">Download receipt (PDF)</a>
            <a href="{{ url('/contact') }}" class="btn btn-primary" style="background:#3a6ea5;">Contact us</a>
            @if($booking->isCancellable())
                <a href="{{ $booking->cancelUrl() }}" class="btn btn-danger">Cancel this booking</a>
            @endif
        </div>

        <div class="attach-note">
            &#128206; Your booking receipt (PDF) is attached to this email. You can also download it any
            time from your <a href="{{ $booking->receiptUrl() }}">booking page</a>.
        </div>

        <p style="margin-top:22px;font-size:13px;color:#666;">
            Need to change something or have a question? Call us on
            <a href="tel:+441273757373">+44 1273 757373</a> or use the contact link above.
        </p>
    </div>

    <div class="footer">
        <p>BN Taxi Brighton - Professional 24/7 Taxi Services</p>
        <p>Call +44 1273 757373 &nbsp;|&nbsp; {{ url('/contact') }}</p>
        <p>&copy; {{ date('Y') }} BN Taxi. All rights reserved.</p>
    </div>
</div>
</body>
</html>
