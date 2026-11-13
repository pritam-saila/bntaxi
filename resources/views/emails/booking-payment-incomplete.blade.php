<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking not completed {{ $booking->booking_id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; color: #222; }
        .container { max-width: 640px; margin: 24px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,.06); }
        .header { background-color: #b91c1c; padding: 22px 20px; color: #fff; }
        .header h1 { margin: 0; font-size: 19px; }
        .header p { margin: 4px 0 0; font-size: 12px; opacity: .9; }
        .content { padding: 24px 22px; }
        .alert-box { padding: 14px 16px; border-radius: 8px; margin-bottom: 18px; font-size: 14px; line-height: 1.5; background-color: #f8d7da; color: #721c24; }
        .ref { font-size: 13px; color: #555; margin-bottom: 16px; }
        .ref strong { color: #0b3c5d; font-size: 15px; }
        .section-title { font-size: 13px; font-weight: bold; color: #0b3c5d; border-bottom: 2px solid #eaeaea; padding-bottom: 6px; margin: 20px 0 12px; text-transform: uppercase; }
        .detail-table { width: 100%; border-collapse: collapse; }
        .detail-table th { text-align: left; padding: 9px 10px; background-color: #f8f9fa; border-bottom: 1px solid #eee; width: 36%; font-weight: 600; font-size: 13px; }
        .detail-table td { padding: 9px 10px; border-bottom: 1px solid #eee; font-size: 13px; }
        .btn-row { text-align: center; margin: 26px 0 6px; }
        .btn { display: inline-block; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; background: #0b3c5d; color: #fff; }
        .footer { background-color: #f8f9fa; text-align: center; padding: 16px; font-size: 11px; color: #888; border-top: 1px solid #eee; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Booking not completed</h1>
        <p>Card payment was not completed &mdash; this booking has been cancelled</p>
    </div>

    <div class="content">
        @if($forAdmin)
            <div class="alert-box">
                <strong>{{ $booking->name }}</strong> started an online booking and chose to pay by card, but the
                payment was never completed. The booking has been <strong>cancelled automatically</strong> and no
                money was taken. The customer has been emailed. Their contact details are below if you would
                like to follow up.
            </div>
        @else
            <div class="alert-box">
                Hello {{ $booking->name }},<br><br>
                Your booking was <strong>not completed</strong> because the card payment did not go through, so
                <strong>no taxi has been booked</strong> and no money has been taken.<br><br>
                If you still need this journey, please make a new booking on our website or call us on
                +44 01273 757373.
            </div>
        @endif

        <div class="ref">
            Reference <strong>{{ $booking->booking_id }}</strong>
            &nbsp;&bull;&nbsp; Started {{ optional($booking->created_at)->format('d M Y H:i') }}
        </div>

        @if($forAdmin)
            <div class="section-title">Customer</div>
            <table class="detail-table">
                <tr><th>Name</th><td>{{ $booking->name }}</td></tr>
                <tr><th>Phone</th><td><a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a></td></tr>
                <tr><th>Email</th><td><a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></td></tr>
            </table>
        @endif

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
            <tr><th>Fare</th><td>£{{ number_format((float) $booking->price, 2) }}</td></tr>
            <tr><th>Payment</th><td>Card (online) &mdash; not completed</td></tr>
            <tr><th>Booking status</th><td>Cancelled</td></tr>
        </table>

        <div class="btn-row">
            @if($forAdmin)
                <a href="{{ route('admbook.show', $booking->id) }}" class="btn">Open in admin</a>
            @else
                <a href="{{ url('/') }}" class="btn">Book again</a>
            @endif
        </div>
    </div>

    <div class="footer">
        @if($forAdmin)
            BN Taxi Brighton &mdash; automated dispatch notification
        @else
            BN Taxi Brighton &mdash; Professional 24/7 Taxi Services<br>
            Need help? Call us on +44 01273 757373 or reply to this email.
        @endif
    </div>
</div>
</body>
</html>
