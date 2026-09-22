<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BN Taxi - Booking Update</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #0b3c5d;
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .status-banner {
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border-bottom: 2px solid #ffeeba;
        }
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
            border-bottom: 2px solid #c3e6cb;
        }
        .status-rejected, .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
            border-bottom: 2px solid #f5c6cb;
        }
        .content {
            padding: 30px 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0b3c5d;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 8px;
            margin-top: 25px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-table th {
            text-align: left;
            padding: 10px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            width: 35%;
            font-weight: 600;
            font-size: 14px;
        }
        .detail-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #777777;
            border-top: 1px solid #eee;
        }
        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.4;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>BN TAXI BRIGHTON</h1>
    </div>

    <!-- Status Banner -->
    @if($data['status'] === 'PENDING APPROVAL')
        <div class="status-banner status-pending">
            Booking Status: Pending Approval
        </div>
    @elseif($data['status'] === 'CONFIRMED')
        <div class="status-banner status-confirmed">
            Booking Status: Confirmed
        </div>
    @elseif($data['status'] === 'REJECTED')
        <div class="status-banner status-rejected">
            Booking Status: Not Accepted / Rejected
        </div>
    @elseif($data['status'] === 'CANCELLED')
        <div class="status-banner status-cancelled">
            Booking Status: Cancelled
        </div>
    @else
        <div class="status-banner status-pending">
            Booking Status: {{ $data['status'] }}
        </div>
    @endif

    <div class="content">
        <!-- Message Intro -->
        @if($data['status'] === 'PENDING APPROVAL')
            <div class="alert-box status-pending">
                <strong>Please Note:</strong> Your booking request has been received and is currently <strong>PENDING APPROVAL</strong>. BN Taxi has not yet accepted this booking. We will review availability and confirm your journey shortly.
            </div>
        @elseif($data['status'] === 'CONFIRMED')
            <div class="alert-box status-confirmed">
                <strong>Great News!</strong> BN Taxi has accepted your booking request. Your journey is now <strong>CONFIRMED</strong>. See you at your scheduled pickup time!
            </div>
        @elseif($data['status'] === 'REJECTED')
            <div class="alert-box status-rejected">
                <strong>We Are Sorry:</strong> We are unable to accept your booking request at this time. <br>
                <strong>Reason:</strong> {{ $data['rejection_reason'] ?? 'Availability constraints.' }}<br>
                @if($data['payment_method'] === 'stripe' && $data['payment_status'] === 'paid')
                    A full refund has been initiated to your original payment method.
                @elseif($data['payment_status'] === 'paid')
                    A refund will be processed to you directly.
                @endif
            </div>
        @elseif($data['status'] === 'CANCELLED')
            <div class="alert-box status-rejected">
                This booking has been <strong>CANCELLED</strong>. <br>
                @if($data['cancellation_reason'])
                    <strong>Reason:</strong> {{ $data['cancellation_reason'] }}<br>
                @endif
                @if($data['refund_amount'] && $data['refund_amount'] > 0)
                    A refund of £{{ number_format($data['refund_amount'], 2) }} has been initiated.
                @endif
            </div>
        @endif

        <!-- Booking details -->
        <div class="section-title">Booking Details</div>
        <table class="detail-table">
            <tr>
                <th>Booking Reference</th>
                <td><strong>{{ $data['booking_id'] }}</strong></td>
            </tr>
            <tr>
                <th>Pickup Date & Time</th>
                <td><strong>{{ $data['pickup_date'] }}</strong> at <strong>{{ $data['pickup_time'] }}</strong></td>
            </tr>
            @if(!empty($data['is_return']))
            <tr>
                <th>Return Date & Time</th>
                <td>{{ $data['return_date'] }} at {{ $data['return_time'] }}</td>
            </tr>
            @endif
            <tr>
                <th>Pickup Address</th>
                <td>{{ $data['pickup'] }}</td>
            </tr>
            @if(!empty($data['vias']) && is_array($data['vias']) && count($data['vias']) > 2)
            <tr>
                <th>Stops (Via)</th>
                <td>
                    @foreach($data['vias'] as $key => $via)
                        @if($key > 0 && $key < count($data['vias']) - 1)
                            • {{ $via }}<br>
                        @endif
                    @endforeach
                </td>
            </tr>
            @endif
            <tr>
                <th>Destination</th>
                <td>{{ $data['dropoff'] }}</td>
            </tr>
            <tr>
                <th>Passengers</th>
                <td>{{ $data['passengers'] ?? '1' }}</td>
            </tr>
            <tr>
                <th>Bags</th>
                <td>{{ $data['bags'] ?? '0' }}</td>
            </tr>
            @if(!empty($data['special_instructions']))
            <tr>
                <th>Special Instructions</th>
                <td>{{ $data['special_instructions'] }}</td>
            </tr>
            @endif
        </table>

        <!-- Payment details -->
        <div class="section-title">Fare & Payment Method</div>
        <table class="detail-table">
            <tr>
                <th>Total Price</th>
                <td><strong style="color: #0b3c5d; font-size: 16px;">£{{ number_format($data['price'], 2) }}</strong></td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>{{ $data->payment_method_display }}</td>
            </tr>
            <tr>
                <th>Payment Status</th>
                <td>{{ $data->payment_status_label }}</td>
            </tr>
            @if((float) $data['amount_paid'] > 0 && $data->outstandingBalance() > 0)
            <tr>
                <th>Amount Paid</th>
                <td>£{{ number_format((float) $data['amount_paid'], 2) }}</td>
            </tr>
            <tr>
                <th>Outstanding Balance</th>
                <td>£{{ number_format($data->outstandingBalance(), 2) }}</td>
            </tr>
            @endif
        </table>

        <!-- Flight details -->
        @if(!empty($data['flight_number']))
        <div class="section-title">Flight details</div>
        <table class="detail-table">
            <tr>
                <th>Flight Number</th>
                <td>{{ $data['flight_number'] }}</td>
            </tr>
            <tr>
                <th>Airline</th>
                <td>{{ $data['airline'] }}</td>
            </tr>
            <tr>
                <th>Airport Name</th>
                <td>{{ $data['flight_airport'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Flight Direction</th>
                <td>{{ $data['flight_direction'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Origin / Destination</th>
                <td>{{ $data['flight_origin_destination'] ?? 'N/A' }}</td>
            </tr>
            @if(!empty($data['flight_scheduled_time']))
            <tr>
                <th>Scheduled Flight Time</th>
                <td>{{ $data['flight_scheduled_time'] }}</td>
            </tr>
            @endif
        </table>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>BN Taxi Brighton - Professional 24/7 Taxi Services</p>
        <p>Need help? Call us at +44 01273 757373 or reply to this email.</p>
        <p>&copy; {{ date('Y') }} BN Taxi. All rights reserved.</p>
    </div>
</div>

</body>
</html>
