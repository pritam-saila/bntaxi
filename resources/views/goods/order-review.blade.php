<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime - Order Review</title>

        @include('goods.include.assets')
        
        @stylesheet('goods/css/pages/order-review.css')
    </head>
    <body>
        @include('goods.include.header')

        <div class="banners">
            <div class="banner-paras">
                <h1>Order Review</h1>
                <h5>Home // <a href="">Order Review</a></h5>
            </div>
        </div>

        <div class="banner_bottom">
            <div class="container">
                <h2>Review your order details below</h2>
            </div>
        </div>

        <main class="main pages">
            <div class="page-content pt-50 pb-50 bg-light">
                <div class="container">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session()->get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ url('/order-review') }}">
                        @csrf
                        <div class="row">
                            <!-- LEFT COLUMN -->
                            <div class="col-lg-8 mb-4">
                                <!-- Journey Details Card -->
                                <div class="card shadow-sm border-0 rounded-3 mb-4">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4 font-weight-bold" style="color: #101d3b;"><i class="fa fa-route me-2"></i> Journey Details</h5>
                                        
                                        <div class="row mb-4">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <p class="text-muted mb-1 small text-uppercase font-weight-bold">Pickup</p>
                                                <p class="mb-3 font-weight-bold"><i class="fa fa-map-marker-alt text-success me-2"></i> {{ $pickup ?? 'N/A' }}</p>
                                                
                                                @if(isset($distancearr) && count($distancearr) > 2)
                                                    <p class="text-muted mb-1 small text-uppercase font-weight-bold">Vias</p>
                                                    <ul class="list-unstyled mb-3 border-start ms-2 ps-3" style="border-color: #eee !important; border-left-width: 2px !important;">
                                                    @foreach($distancearr as $index => $via)
                                                        @if($index > 0 && $index < count($distancearr) - 1)
                                                            <li class="mb-1 text-muted small"><i class="fa fa-circle text-secondary me-2" style="font-size: 6px; vertical-align: middle;"></i> {{ $via }}</li>
                                                        @endif
                                                    @endforeach
                                                    </ul>
                                                @endif

                                                <p class="text-muted mb-1 small text-uppercase font-weight-bold">Dropoff</p>
                                                <p class="mb-0 font-weight-bold"><i class="fa fa-map-pin text-danger me-2"></i> {{ $dropoff ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted mb-1 small text-uppercase font-weight-bold">Pickup Time</p>
                                                <p class="mb-3 font-weight-bold"><i class="fa fa-calendar-alt text-primary me-2"></i> {{ $pickup_date ?? 'N/A' }} <span class="ms-2"><i class="fa fa-clock text-primary me-2"></i> {{ $pickup_time ?? 'N/A' }}</span></p>

                                                @if(isset($is_return) && $is_return == '1')
                                                    <p class="text-muted mb-1 small text-uppercase font-weight-bold">Return Time</p>
                                                    <p class="mb-3 font-weight-bold text-success"><i class="fa fa-calendar-check me-2"></i> {{ $return_date ?? 'N/A' }} <span class="ms-2"><i class="fa fa-clock me-2"></i> {{ $return_time ?? 'N/A' }}</span></p>
                                                @endif
                                                
                                                <p class="text-muted mb-1 small text-uppercase font-weight-bold">Total Distance</p>
                                                <p class="mb-0 font-weight-bold"><i class="fa fa-road text-info me-2"></i> {{ number_format($distance ?? 0, 2) }} miles</p>
                                            </div>
                                        </div>

                                        <!-- ROUTE MAP SECTION -->
                                        @php
                                            $saddr = rawurlencode($pickup ?? '');
                                            if (isset($distancearr) && is_array($distancearr) && count($distancearr) > 1) {
                                                $daddr_parts = array_slice($distancearr, 1);
                                                $daddr = implode('+to:', array_map('rawurlencode', $daddr_parts));
                                            } else {
                                                $daddr = rawurlencode($dropoff ?? '');
                                            }
                                            $mapUrl = "https://maps.google.com/maps?f=d&source=s_d&dirflg=d&saddr=" . $saddr . "&daddr=" . $daddr . "&hl=en&output=embed";
                                        @endphp
                                        <div class="rounded-3 overflow-hidden shadow-sm mt-2" style="height: 300px; border: 1px solid #ddd;">
                                            <iframe src="{{ $mapUrl }}" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                                        </div>
                                    </div>
                                </div>

                                <!-- Passenger Details Card -->
                                <div class="card shadow-sm border-0 rounded-3">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4 font-weight-bold" style="color: #101d3b;"><i class="fa fa-user me-2"></i> Passenger & Journey details</h5>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Full Name *</label>
                                                <input type="text" class="form-control bg-light px-3 py-2" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}" required placeholder="e.g. John Doe" style="border: 1px solid #eee;">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Email Address *</label>
                                                <input type="email" class="form-control bg-light px-3 py-2" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}" required placeholder="e.g. john@example.com" style="border: 1px solid #eee;">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Phone Number *</label>
                                                <input type="text" class="form-control bg-light px-3 py-2" name="phone" value="{{ auth()->check() ? auth()->user()->phone : '' }}" required placeholder="e.g. +44 7700 900000" style="border: 1px solid #eee;">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Number of Passengers *</label>
                                                <input type="number" class="form-control bg-light px-3 py-2" name="passengers" min="1" max="16" required placeholder="e.g. 2" style="border: 1px solid #eee;">
                                            </div>
                                            <!--<div class="col-md-6 mb-3">-->
                                            <!--    <label class="form-label text-muted small font-weight-bold text-uppercase">Number of Bags *</label>-->
                                            <!--    <input type="number" class="form-control bg-light px-3 py-2" name="bags" min="0" max="16" placeholder="e.g. 2" required style="border: 1px solid #eee;">-->
                                            <!--</div>-->
                                            <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small font-weight-bold text-uppercase">
                                                Number of Bags *
                                            </label>
                                        
                                            <input type="number"
                                                   class="form-control bg-light px-3 py-2"
                                                   name="bags"
                                                   min="0"
                                                   max="4"
                                                   step="1"
                                                   placeholder="e.g. 2"
                                                   required
                                                   style="border: 1px solid #eee;">
                                        
                                            <small class="text-muted" id="bags-note">
                                                Maximum 4 bags allowed
                                                (2 large suitcases + 2 small bags).
                                            </small>
                                        </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Special Instructions / Notes</label>
                                                <textarea class="form-control bg-light px-3 py-2" name="special_instructions" rows="3" placeholder="Enter any extra requests (e.g. child seat, pickup notes, extra stops details)..." style="border: 1px solid #eee;"></textarea>
                                            </div>
                                        </div>

                                        <h5 class="mb-4 mt-3 font-weight-bold" style="color: #101d3b;"><i class="fa fa-plane me-2"></i> Flight details (Optional - Airport Bookings Only)</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Flight Number</label>
                                                <input type="text" class="form-control bg-light px-3 py-2" name="flight_number" placeholder="e.g. BA123" style="border: 1px solid #eee;">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Airline</label>
                                                <input type="text" class="form-control bg-light px-3 py-2" name="airline" placeholder="e.g. British Airways" style="border: 1px solid #eee;">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Airport Name</label>
                                                <input type="text" class="form-control bg-light px-3 py-2" name="flight_airport" placeholder="e.g. Gatwick North Terminal" style="border: 1px solid #eee;">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Flight Direction</label>
                                                <select class="form-control bg-light px-3 py-2" name="flight_direction" style="border: 1px solid #eee;">
                                                    <option value="">Select Direction</option>
                                                    <option value="Arrival">Arrival</option>
                                                    <option value="Departure">Departure</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Flight Origin / Destination</label>
                                                <input type="text" class="form-control bg-light px-3 py-2" name="flight_origin_destination" placeholder="e.g. New York JFK" style="border: 1px solid #eee;">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small font-weight-bold text-uppercase">Scheduled Flight Time / Arrival Time</label>
                                                <input type="time" class="form-control bg-light px-3 py-2" name="flight_scheduled_time" style="border: 1px solid #eee;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN -->
                            <div class="col-lg-4">
                                <div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 20px; z-index: 1;">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4 font-weight-bold" style="color: #101d3b;"><i class="fa fa-car me-2"></i> Order Summary</h5>
                                        
                                        @if(isset($cardata))
                                        <div class="text-center mb-4">
                                            @if($cardata->image)
                                                <img src="{{ url(Storage::url($cardata->image)) }}" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 120px; object-fit: contain;">
                                            @else
                                                <img src="https://crcdiag.com/bntaxifinal/wp-content/uploads/Exploring-the-True-Essence-of-BN-Taxis-Brighton-Anytime-Luxury-Car-Hire-Service-400x250.jpg" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 120px; object-fit: contain;">
                                            @endif
                                            <h5 class="font-weight-bold mb-1">{{ $cardata->name }}</h5>
                                            <p class="text-muted small mb-0">{{ $cardata->description }}</p>
                                        </div>
                                        @endif

                                        <hr style="border-color: #eee;">
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Estimated Fare</span>
                                            <span class="font-weight-bold">£{{ number_format($price ?? 0, 2) }}</span>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="border-color: #eee !important;">
                                            <h5 class="font-weight-bold mb-0">Total</h5>
                                            <h3 class="mb-0 font-weight-bold" style="color: #267fca;">£{{ number_format($price ?? 0, 2) }}</h3>
                                        </div>

                                        <!-- Hidden fields to carry the data forward -->
                                        <input type="hidden" name="car_id" value="{{ $car_id ?? '' }}">
                                        <input type="hidden" name="distance" value="{{ $distance ?? 0 }}">
                                        <input type="hidden" name="price" value="{{ $price ?? 0 }}">
                                        <input type="hidden" name="pickup" value="{{ $pickup ?? '' }}">
                                        <input type="hidden" name="dropoff" value="{{ $dropoff ?? '' }}">
                                        @if(isset($distancearr))
                                            @foreach($distancearr as $via)
                                                <input type="hidden" name="distancearr[]" value="{{ $via }}">
                                            @endforeach
                                        @endif
                                        <input type="hidden" name="pickup_date" value="{{ $pickup_date ?? '' }}">
                                        <input type="hidden" name="pickup_time" value="{{ $pickup_time ?? '' }}">
                                        <input type="hidden" name="return_date" value="{{ $return_date ?? '' }}">
                                        <input type="hidden" name="return_time" value="{{ $return_time ?? '' }}">
                                        <input type="hidden" name="is_return" value="{{ $is_return ?? '0' }}">

                                        <!-- Guest registration checkbox -->
                                        @if(!auth()->check())
                                            <div class="form-check mt-3 text-start mb-3">
                                                <input class="form-check-input" type="checkbox" name="create_account" id="createAccountCheck" value="1" checked>
                                                <label class="form-check-label small text-muted font-weight-bold" for="createAccountCheck" style="cursor:pointer;">
                                                    Create an account to make it easy to book next time
                                                </label>
                                            </div>
                                        @endif

                                        <!-- Payment Method Selection -->
                                        <div class="mb-3 text-start mt-3">
                                            <label class="form-label text-muted small font-weight-bold text-uppercase">Payment Method</label>
                                            <select class="form-control bg-light px-3 py-2" name="payment_method" id="paymentMethodSelect" style="border: 1px solid #eee;">
                                                <option value="stripe">Pay Now (Card/Online)</option>
                                                <option value="cash">Pay in Car (Cash/Card to Driver)</option>
                                            </select>
                                        </div>

                                        <div class="alert alert-warning border-0 p-3 mb-3 text-start" style="border-radius: 8px; font-size: 13px; line-height: 1.4;">
                                            <i class="fa fa-info-circle me-1 text-warning"></i>
                                            <strong>Booking Protection Rule:</strong> Your booking is only accepted once BN Taxi has sent a confirmation email. It is marked as <strong>PENDING APPROVAL</strong> until then.
                                        </div>

                                        <button type="submit" class="btn btn-success btn-lg w-100 mt-2 shadow-sm font-weight-bold py-3" style="border-radius: 8px;">
                                            Confirm Booking Request <i class="fa fa-arrow-right ms-2"></i>
                                        </button>
                                        
                                        <p class="text-center text-muted small mt-3 mb-0"><i class="fa fa-lock me-1"></i> Secure and encrypted booking.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        @include('goods.include.footer')

    </body>
</html>