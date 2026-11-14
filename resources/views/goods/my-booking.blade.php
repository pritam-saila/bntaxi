<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BN Taxi Anytime</title>

    @include('goods.include.assets')

    @stylesheet('goods/css/pages/my-booking.css')
</head>

<body>

    @include('goods.include.header')

    <div class="bntaxi-dashboard">

        <div class="container mt-4">

            <div class="row">

                <!-- SIDEBAR -->
                <div class="col-md-3 bntaxi-sidebar">
                    @include('goods.include.dashboad-menu')
                </div>


                <!-- MAIN CONTENT -->
                <div class="col-md-9 bntaxi-main">

                    <h3 class="mb-4">My Bookings</h3>

                    <form method="GET" action="{{ url('/my-booking') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control"
                                   placeholder="Search by reference, pickup, destination, status or date...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Search</button>
                                @if(!empty($search))
                                    <a href="{{ url('/my-booking') }}" class="btn btn-outline-secondary">Clear</a>
                                @endif
                            </div>
                        </div>
                        @if(!empty($search))
                            <small class="text-muted">Showing results for &ldquo;{{ $search }}&rdquo; &mdash; {{ $bookings->total() }} found.</small>
                        @endif
                    </form>

                    <div class="bntaxi-table-card">

                        <table class="table table-hover align-middle">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Route</th>
                                    <th>Car</th>
                                    <th>Driver</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($bookings as $booking)

                                <tr>

                                    <td>{{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                                    </td>

                                    <td>
                                        {{ $booking->pickup }} &rarr; {{ $booking->dropoff }}
                                    </td>

                                    <td>
                                        {{ $booking->carDetail->name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $booking->driver_id ? 'Assigned' : 'Not Assigned' }}
                                    </td>

                                    <td>

                                        @if($booking->status == 'Active')

                                            <span class="badge bg-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ $booking->status }}
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <button
                                            class="btn btn-sm btn-outline-primary"
                                            data-toggle="modal"
                                            data-target="#viewBookingModal{{ $booking->id }}">

                                            View

                                        </button>

                                    </td>

                                </tr>


                                <!-- =====================================================
                                     VIEW BOOKING MODAL
                                ====================================================== -->

                                <div
                                    class="modal fade bntaxi-booking-modal"
                                    id="viewBookingModal{{ $booking->id }}"
                                    tabindex="-1"
                                    role="dialog"
                                    aria-labelledby="viewBookingModalLabel{{ $booking->id }}"
                                    aria-hidden="true">

                                    <div
                                        class="modal-dialog modal-lg"
                                        role="document">

                                        <div class="modal-content">


                                            <!-- HEADER -->

                                            <div class="modal-header">

                                                <h5
                                                    class="modal-title"
                                                    id="viewBookingModalLabel{{ $booking->id }}">

                                                    Booking Details ({{ $booking->booking_id }})

                                                </h5>

                                                <button
                                                    type="button"
                                                    class="close"
                                                    data-dismiss="modal"
                                                    aria-label="Close">

                                                    <span aria-hidden="true">
                                                        &times;
                                                    </span>

                                                </button>

                                            </div>


                                            <!-- BODY -->

                                            <div class="modal-body">


                                                <!-- BASIC INFORMATION -->

                                                <div class="bntaxi-info-grid">


                                                    <!-- NAME -->

                                                    <div class="bntaxi-info-item">

                                                        <div class="bntaxi-info-icon">
                                                            <i class="fi-rs-user"></i>
                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>Name:</strong>

                                                            <span>
                                                                {{ $booking->name }}
                                                            </span>

                                                        </div>

                                                    </div>


                                                    <!-- EMAIL -->

                                                    <div class="bntaxi-info-item">

                                                        <div class="bntaxi-info-icon">
                                                            <i class="fi-rs-envelope"></i>
                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>Email:</strong>

                                                            <span>
                                                                {{ $booking->email }}
                                                            </span>

                                                        </div>

                                                    </div>


                                                    <!-- PHONE -->

                                                    <div class="bntaxi-info-item">

                                                        <div class="bntaxi-info-icon">
                                                            <i class="fi-rs-phone-call"></i>
                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>Phone:</strong>

                                                            <span class="bntaxi-phone">
                                                                {{ $booking->phone }}
                                                            </span>

                                                        </div>

                                                    </div>


                                                    <!-- STATUS -->

                                                    <div class="bntaxi-info-item">

                                                        <div class="bntaxi-info-icon">
                                                            <i class="fi-rs-info"></i>
                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>Status:</strong>

                                                            @php
                                                                $statusClass = 'bntaxi-status-pending';

                                                                if ($booking->status == 'Active') {
                                                                    $statusClass = 'bntaxi-status-active';
                                                                } elseif ($booking->status == 'COMPLETED') {
                                                                    $statusClass = 'bntaxi-status-completed';
                                                                } elseif ($booking->status == 'CANCELLED') {
                                                                    $statusClass = 'bntaxi-status-cancelled';
                                                                } elseif ($booking->status == 'REJECTED') {
                                                                    $statusClass = 'bntaxi-status-rejected';
                                                                }
                                                            @endphp

                                                            <span class="bntaxi-status {{ $statusClass }}">
                                                                {{ $booking->status }}
                                                            </span>

                                                        </div>

                                                    </div>


                                                    <!-- PAYMENT STATUS -->

                                                    <div class="bntaxi-info-item">

                                                        <div class="bntaxi-info-icon">
                                                            <i class="fi-rs-credit-card"></i>
                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>Payment Status:</strong>

                                                            @php
                                                                $paymentClass = 'bntaxi-payment-pending';

                                                                if ($booking->payment_status === 'paid') {
                                                                    $paymentClass = 'bntaxi-payment-paid';
                                                                } elseif (in_array($booking->payment_status, ['payment_failed', 'failed'])) {
                                                                    $paymentClass = 'bntaxi-payment-failed';
                                                                }
                                                            @endphp

                                                            <span class="bntaxi-payment {{ $paymentClass }}">
                                                                {{ $booking->payment_status_label }}
                                                            </span>

                                                        </div>

                                                    </div>

                                                    <div class="bntaxi-info-item">

                                                        <div class="bntaxi-info-icon">
                                                            <i class="fi-rs-wallet"></i>
                                                        </div>

                                                        <div class="bntaxi-info-content">
                                                            <strong>Payment Method:</strong>
                                                            <span>{{ $booking->payment_method_display }}</span>
                                                            @if($booking->outstandingBalance() > 0 && (float) $booking->amount_paid > 0)
                                                                <br><small>Paid £{{ number_format((float) $booking->amount_paid, 2) }} &middot; Outstanding £{{ number_format($booking->outstandingBalance(), 2) }}</small>
                                                            @endif
                                                        </div>

                                                    </div>


                                                    <!-- CAR -->

                                                    <div class="bntaxi-info-item">

                                                        <div class="bntaxi-info-icon">
                                                            <i class="fi-rs-car"></i>
                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>Car:</strong>

                                                            <span class="bntaxi-car">
                                                                {{ $booking->carDetail->name ?? 'N/A' }}
                                                            </span>

                                                        </div>

                                                    </div>


                                                    <!-- PRICE -->

                                                    <div class="bntaxi-info-item">

                                                        <div
                                                            class="bntaxi-info-icon"
                                                            style="background:#edf9f0;color:#168b3a;">

                                                            £

                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>Price:</strong>

                                                            <span class="bntaxi-price">
                                                                £{{ number_format($booking->price, 2) }}
                                                            </span>

                                                        </div>

                                                    </div>


                                                    <!-- DISTANCE -->

                                                    <div class="bntaxi-info-item">

                                                        <div
                                                            class="bntaxi-info-icon"
                                                            style="background:#edf5ff;color:#1475dc;">

                                                            <i class="fi-rs-marker"></i>

                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>Distance:</strong>

                                                            <span class="bntaxi-distance">
                                                                {{ number_format($booking->distance, 2) }} miles
                                                            </span>

                                                        </div>

                                                    </div>

                                                </div>


                                                <!-- PICKUP DATE & TIME -->

                                                <div class="bntaxi-modal-divider"></div>

                                                <div class="bntaxi-datetime">

                                                    <div class="bntaxi-info-icon">

                                                        <i class="fi-rs-calendar"></i>

                                                    </div>

                                                    <div class="bntaxi-info-content">

                                                        <strong>
                                                            Pickup Date & Time:
                                                        </strong>

                                                        <span>
                                                            {{ $booking->pickup_date }}
                                                            {{ $booking->pickup_time }}
                                                        </span>

                                                    </div>

                                                </div>


                                                <!-- RETURN DATE & TIME -->

                                                @if($booking->is_return)

                                                    <div class="bntaxi-datetime">

                                                        <div class="bntaxi-info-icon">

                                                            <i class="fi-rs-calendar"></i>

                                                        </div>

                                                        <div class="bntaxi-info-content">

                                                            <strong>
                                                                Return Date & Time:
                                                            </strong>

                                                            <span>
                                                                {{ $booking->return_date }}
                                                                {{ $booking->return_time }}
                                                            </span>

                                                        </div>

                                                    </div>

                                                @endif


                                                <div class="bntaxi-modal-divider"></div>


                                                <!-- PICKUP LOCATION -->

                                                <div class="bntaxi-location-box">

                                                    <div class="bntaxi-location-icon">

                                                        <i class="fi-rs-arrow-up"></i>

                                                    </div>

                                                    <div class="bntaxi-location-content">

                                                        <span class="bntaxi-location-label">
                                                            Pickup Location:
                                                        </span>

                                                        <span class="bntaxi-location-address">
                                                            {{ $booking->pickup }}
                                                        </span>

                                                    </div>

                                                    <span class="bntaxi-location-action">
                                                        Pick Up
                                                    </span>

                                                </div>


                                                <!-- VIAS -->

                                                @if(isset($booking->distancearr) && is_array($booking->distancearr) && count($booking->distancearr) > 2)

                                                    <div class="bntaxi-vias">

                                                        <div class="bntaxi-vias-title">
                                                            Via Locations
                                                        </div>

                                                        <ul>

                                                            @foreach($booking->distancearr as $index => $via)

                                                                @if($index > 0 && $index < count($booking->distancearr) - 1)

                                                                    <li>
                                                                        {{ $via }}
                                                                    </li>

                                                                @endif

                                                            @endforeach

                                                        </ul>

                                                    </div>

                                                @endif


                                                <!-- DROPOFF LOCATION -->

                                                <div class="bntaxi-location-box dropoff">

                                                    <div class="bntaxi-location-icon">

                                                        <i class="fi-rs-arrow-down"></i>

                                                    </div>

                                                    <div class="bntaxi-location-content">

                                                        <span class="bntaxi-location-label">
                                                            Dropoff Location:
                                                        </span>

                                                        <span class="bntaxi-location-address">
                                                            {{ $booking->dropoff }}
                                                        </span>

                                                    </div>

                                                    <span class="bntaxi-location-action">
                                                        Drop Off
                                                    </span>

                                                </div>


                                            </div>


                                            <!-- FOOTER -->

                                            <div class="modal-footer">

                                                @if($booking->access_token)
                                                    <a
                                                        href="{{ route('booking.receipt', $booking->access_token) }}"
                                                        target="_blank"
                                                        rel="noopener"
                                                        class="btn bntaxi-close-btn"
                                                        style="background:#16a34a !important;border-color:#16a34a !important;">

                                                        &#128196; Download Receipt (PDF)

                                                    </a>
                                                @endif

                                                @if(!in_array($booking->status, ['CANCELLED', 'REJECTED', 'COMPLETED']))

                                                    <form
                                                        action="{{ route('user.booking.cancel', $booking->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to cancel this booking request?');"
                                                        style="display:inline-block;">

                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="btn bntaxi-cancel-btn">

                                                            ✕ Cancel Booking

                                                        </button>

                                                    </form>

                                                @endif

                                                <button
                                                    type="button"
                                                    class="btn bntaxi-close-btn"
                                                    data-dismiss="modal">

                                                    Close

                                                </button>

                                            </div>


                                        </div>

                                    </div>

                                </div>


                                @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center">

                                        No bookings found.

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    @if($bookings->hasPages())
                        <div class="mt-3 d-flex justify-content-center bntaxi-pagination">
                            {{ $bookings->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>


    @include('goods.include.footer')

</body>
</html>