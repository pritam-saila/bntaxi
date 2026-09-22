<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Receipt {{ $booking->booking_id }}</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { color: #222; font-size: 12px; margin: 0; }
        .wrap { padding: 30px 34px; }
        .head { border-bottom: 3px solid #0b3c5d; padding-bottom: 12px; margin-bottom: 18px; }
        .head h1 { margin: 0; color: #0b3c5d; font-size: 22px; letter-spacing: .5px; }
        .head .sub { color: #666; font-size: 11px; margin-top: 3px; }
        .meta { width: 100%; margin-bottom: 18px; }
        .meta td { padding: 2px 0; vertical-align: top; font-size: 11px; }
        .meta .lbl { color: #666; width: 130px; }
        h2 { font-size: 12px; text-transform: uppercase; letter-spacing: .5px;
             color: #0b3c5d; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin: 20px 0 8px; }
        table.detail { width: 100%; border-collapse: collapse; }
        table.detail th { text-align: left; width: 38%; padding: 6px 8px; background: #f5f7fa;
                          border: 1px solid #e6e9ee; font-weight: bold; font-size: 11px; }
        table.detail td { padding: 6px 8px; border: 1px solid #e6e9ee; font-size: 11px; }
        .total td { font-size: 14px; font-weight: bold; color: #0b3c5d; }
        .note { margin-top: 18px; padding: 10px 12px; background: #fff8e1; border: 1px solid #ffe08a;
                font-size: 10.5px; color: #7a5b00; }
        .foot { margin-top: 26px; border-top: 1px solid #ddd; padding-top: 10px;
                color: #888; font-size: 10px; text-align: center; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="head">
        <h1>BN TAXI BRIGHTON</h1>
        <div class="sub">Professional 24/7 Taxi Services &nbsp;•&nbsp; +44 1273 757373 &nbsp;•&nbsp; {{ config('app.url') }}</div>
    </div>

    <table class="meta">
        <tr>
            <td class="lbl">Receipt for</td>
            <td><strong>Booking {{ $booking->booking_id }}</strong></td>
            <td class="lbl">Issued</td>
            <td>{{ now()->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <td class="lbl">Booked on</td>
            <td>{{ optional($booking->created_at)->format('d M Y H:i') }}</td>
            <td class="lbl">Booking status</td>
            <td>{{ $booking->status }}</td>
        </tr>
    </table>

    <h2>Customer</h2>
    <table class="detail">
        <tr><th>Name</th><td>{{ $booking->name }}</td></tr>
        <tr><th>Email</th><td>{{ $booking->email }}</td></tr>
        <tr><th>Phone</th><td>{{ $booking->phone }}</td></tr>
    </table>

    <h2>Journey</h2>
    <table class="detail">
        <tr><th>Pickup</th><td>{{ $booking->pickup }}</td></tr>
        @if(is_array($booking->vias) && count($booking->vias) > 2)
            @foreach($booking->vias as $i => $via)
                @if($i > 0 && $i < count($booking->vias) - 1)
                    <tr><th>Via stop {{ $i }}</th><td>{{ $via }}</td></tr>
                @endif
            @endforeach
        @endif
        <tr><th>Destination</th><td>{{ $booking->dropoff }}</td></tr>
        <tr><th>Pickup date &amp; time</th><td>{{ $booking->pickup_date }} {{ $booking->pickup_time }}</td></tr>
        @if($booking->is_return)
            <tr><th>Return date &amp; time</th><td>{{ $booking->return_date }} {{ $booking->return_time }}</td></tr>
        @endif
        <tr><th>Vehicle</th><td>{{ optional($booking->carDetail)->name ?? 'To be assigned' }}</td></tr>
        <tr><th>Passengers / Bags</th><td>{{ $booking->passengers ?? 1 }} passenger(s), {{ $booking->bags ?? 0 }} bag(s)</td></tr>
        <tr><th>Estimated distance</th><td>{{ $booking->distance ? number_format((float) $booking->distance, 1) . ' miles' : 'N/A' }}</td></tr>
    </table>

    <h2>Payment</h2>
    <table class="detail">
        <tr class="total"><th>Total fare</th><td>£{{ number_format((float) $booking->price, 2) }}</td></tr>
        <tr><th>Payment method</th><td>{{ $booking->payment_method_display }}</td></tr>
        <tr><th>Payment status</th><td>{{ $booking->payment_status_label }}</td></tr>
        <tr><th>Amount paid</th><td>£{{ number_format((float) $booking->amount_paid, 2) }}</td></tr>
        <tr><th>Outstanding balance</th><td>£{{ number_format($booking->outstandingBalance(), 2) }}</td></tr>
    </table>

    @if($booking->status === 'PENDING APPROVAL')
        <div class="note">
            This booking is currently <strong>PENDING APPROVAL</strong>. It is confirmed only once
            BN Taxi sends you a confirmation email. This receipt records the request and any payment taken.
        </div>
    @endif

    <div class="foot">
        BN Taxi Brighton &nbsp;•&nbsp; Reference {{ $booking->booking_id }} &nbsp;•&nbsp;
        Questions? Call +44 1273 757373 or visit {{ url('/contact') }}
    </div>
</div>
</body>
</html>
