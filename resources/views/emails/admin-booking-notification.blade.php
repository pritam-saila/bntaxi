<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Booking {{ $booking->booking_id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; color: #222; }
        .container { max-width: 640px; margin: 24px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,.06); }
        .header { background-color: #16a34a; padding: 22px 20px; color: #fff; }
        .header h1 { margin: 0; font-size: 19px; }
        .header p { margin: 4px 0 0; font-size: 12px; opacity: .9; }
        .content { padding: 24px 22px; }
        .ref { font-size: 13px; color: #555; margin-bottom: 16px; }
        .ref strong { color: #0b3c5d; font-size: 15px; }
        .section-title { font-size: 13px; font-weight: bold; color: #16a34a; border-bottom: 2px solid #eaeaea; padding-bottom: 6px; margin: 20px 0 12px; text-transform: uppercase; }
        .detail-table { width: 100%; border-collapse: collapse; }
        .detail-table th { text-align: left; padding: 9px 10px; background-color: #f8f9fa; border-bottom: 1px solid #eee; width: 36%; font-weight: 600; font-size: 13px; }
        .detail-table td { padding: 9px 10px; border-bottom: 1px solid #eee; font-size: 13px; }
        .pill { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #eaf3ff; color: #0b3c5d; }
        .btn-row { text-align: center; margin: 26px 0 6px; }
        .btn { display: inline-block; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; background: #0b3c5d; color: #fff; }
        .footer { background-color: #f8f9fa; text-align: center; padding: 16px; font-size: 11px; color: #888; border-top: 1px solid #eee; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>New booking received</h1>
        <p>Action required &mdash; this request is PENDING APPROVAL</p>
    </div>

    <div class="content">
        <div class="ref">
            Reference <strong>{{ $booking->booking_id }}</strong>
            &nbsp;&bull;&nbsp; Source: <span class="pill">{{ $booking->source_label }}</span>
            &nbsp;&bull;&nbsp; Received {{ optional($booking->created_at)->format('d M Y H:i') }}
        </div>

        <div class="section-title">Customer</div>
        <table class="detail-table">
            <tr><th>Name</th><td>{{ $booking->name }}</td></tr>
            <tr><th>Phone</th><td><a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a></td></tr>
            <tr><th>Email</th><td><a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></td></tr>
        </table>

        <div class="section-title">Journey</div>
        <table class="detail-table">
            <tr><th>Pickup</th><td>{{ $booking->pickup }}</td></tr>
            @if(is_array($booking->vias) && count($booking->vias) > 2)
                @foreach($booking->vias as $i => $via)
                    @if($i > 0 && $i < count($booking->vias) - 1)
                        <tr><th>Via stop {{ $i }}</th><td>{{ $via }}</td></tr>
                    @endif
                @endforeach
            @endif
            <tr><th>Destination</th><td>{{ $booking->dropoff }}</td></tr>
            <tr><th>Pickup date &amp; time</th><td><strong>{{ $booking->pickup_date }} {{ $booking->pickup_time }}</strong></td></tr>
            @if($booking->is_return)
                <tr><th>Return date &amp; time</th><td>{{ $booking->return_date }} {{ $booking->return_time }}</td></tr>
            @endif
            <tr><th>Vehicle</th><td>{{ optional($booking->carDetail)->name ?? 'To be assigned' }}</td></tr>
            
            <tr>
                <th>Passengers</th>
                <td>{{ $booking->passengers ?? 1 }}</td>
            </tr>
            
            <tr>
                <th>Bags</th>
                <td>{{ $booking->bags ?? 0 }}</td>
            </tr>
            <tr><th>Distance</th><td>{{ $booking->distance ? number_format((float) $booking->distance, 1) . ' miles' : 'N/A' }}</td></tr>
            @if(!empty($booking->special_instructions))
                <tr><th>Special instructions</th><td>{{ $booking->special_instructions }}</td></tr>
            @endif
        </table>

        @if(!empty($booking->flight_number))
            <div class="section-title">Flight</div>
            <table class="detail-table">
                <tr><th>Flight number</th><td>{{ $booking->flight_number }}</td></tr>
                <tr><th>Airline</th><td>{{ $booking->airline ?? 'N/A' }}</td></tr>
                <tr><th>Airport</th><td>{{ $booking->flight_airport ?? 'N/A' }}</td></tr>
                <tr><th>Direction</th><td>{{ $booking->flight_direction ?? 'N/A' }}</td></tr>
                <tr><th>Scheduled time</th><td>{{ $booking->flight_scheduled_time ?? 'N/A' }}</td></tr>
            </table>
        @endif

        <div class="section-title">Fare &amp; Payment</div>
        <table class="detail-table">
            <tr><th>Total fare</th><td><strong style="font-size:15px;color:#0b3c5d;">£{{ number_format((float) $booking->price, 2) }}</strong></td></tr>
            <tr><th>Payment method</th><td>{{ $booking->payment_method_display }}</td></tr>
            <tr><th>Payment status</th><td>{{ $booking->payment_status_label }}</td></tr>
            <tr><th>Amount paid</th><td>£{{ number_format((float) $booking->amount_paid, 2) }}</td></tr>
            <tr><th>Outstanding</th><td>£{{ number_format($booking->outstandingBalance(), 2) }}</td></tr>
        </table>

        <div class="btn-row">
            <a href="{{ route('admbook.show', $booking->id) }}" class="btn">Open in admin</a>
        </div>
    </div>

    <div class="footer">
        BN Taxi Brighton &mdash; automated dispatch notification
    </div>
</div>
</body>
</html>
