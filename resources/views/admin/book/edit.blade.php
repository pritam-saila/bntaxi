@include('admin.include.sidebar')

@php
    $stops = $data->stops;
    $minMiles = (float) \App\Models\Setting::get('minimum_journey_miles', 8);
    $minEnforced = (string) \App\Models\Setting::get('minimum_journey_enforced', '1') === '1';
    $currentDistance = (float) $data->distance;
    $isBelowMin = $currentDistance > 0 && $currentDistance < $minMiles;
@endphp

<style>
    :root {
        --bn-blue: #0757d9;
        --bn-blue-dark: #063b91;
        --bn-green: #16a34a;
        --bn-orange: #f59e0b;
        --bn-red: #dc2626;
        --bn-bg: #f4f7fb;
        --bn-border: #dce5ef;
        --bn-text: #172b4d;
        --bn-muted: #64748b;
    }

    #content { min-height: 100vh; background: var(--bn-bg); padding: 25px !important; }
    .bn-edit-wrapper { max-width: 1180px; margin: 0 auto; }

    .bn-page-header {
        background: linear-gradient(135deg, #0757d9 0%, #063b91 100%);
        border-radius: 16px; padding: 22px 25px; color: #fff; margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(7,87,217,.18);
        display: flex; align-items: center; justify-content: space-between; gap: 15px; flex-wrap: wrap;
    }
    .bn-page-title { display: flex; align-items: center; gap: 14px; }
    .bn-page-icon {
        width: 50px; height: 50px; border-radius: 12px; background: rgba(255,255,255,.15);
        display: flex; align-items: center; justify-content: center; font-size: 23px;
    }
    .bn-page-title h2 { margin: 0; font-size: 23px; font-weight: 800; }
    .bn-page-title p { margin: 4px 0 0; opacity: .85; font-size: 12px; }
    .bn-header-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .bn-booking-ref {
        background: #fff; color: var(--bn-blue); border-radius: 10px; padding: 10px 15px;
        font-size: 12px; font-weight: 800; white-space: nowrap;
    }
    .bn-ghost-btn {
        display: inline-flex; align-items: center; gap: 6px; color: #fff !important;
        border: 1px solid rgba(255,255,255,.4); background: rgba(255,255,255,.10);
        border-radius: 8px; padding: 9px 13px; font-size: 12px; font-weight: 700; text-decoration: none !important;
    }
    .bn-ghost-btn:hover { background: #fff; color: var(--bn-blue) !important; }

    .bn-alert { border-radius: 10px; border: none; box-shadow: 0 3px 12px rgba(0,0,0,.05); font-size: 13px; }

    .bn-section {
        background: #fff; border: 1px solid var(--bn-border); border-radius: 14px;
        box-shadow: 0 4px 18px rgba(31,52,73,.06); overflow: hidden; margin-bottom: 20px;
    }
    .bn-section-head {
        padding: 15px 20px; background: #f8fafc; border-bottom: 1px solid var(--bn-border);
        display: flex; align-items: center; gap: 10px;
    }
    .bn-section-head i { color: var(--bn-blue); font-size: 16px; }
    .bn-section-head h4 { margin: 0; color: var(--bn-text); font-size: 15px; font-weight: 800; }
    .bn-section-head .bn-hint { margin-left: auto; font-size: 11px; color: var(--bn-muted); font-weight: 600; }
    .bn-section-body { padding: 20px; }

    .bn-fg { margin-bottom: 16px; }
    .bn-label {
        display: flex; align-items: center; gap: 6px; margin-bottom: 6px;
        color: #344054; font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .3px;
    }
    .bn-label i { color: var(--bn-blue); width: 14px; }
    .bn-control {
        width: 100%; min-height: 42px; border: 1px solid #cfd9e5; border-radius: 9px;
        padding: 8px 12px; background: #fff; color: #172b4d; font-size: 13px; outline: none;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .bn-control:focus { border-color: var(--bn-blue); box-shadow: 0 0 0 3px rgba(7,87,217,.10); }
    .bn-control[readonly] { background: #eef3f8; color: #64748b; font-weight: 700; }
    textarea.bn-control { min-height: 80px; }

    .bn-readout {
        display: flex; gap: 18px; flex-wrap: wrap; background: #f8fafc; border: 1px dashed #cbd5e1;
        border-radius: 10px; padding: 12px 16px; margin-bottom: 16px;
    }
    .bn-readout .item { font-size: 12px; color: var(--bn-muted); font-weight: 700; }
    .bn-readout .item b { display: block; font-size: 17px; color: var(--bn-text); margin-top: 2px; }

    .bn-stop-row {
        display: flex; gap: 10px; align-items: flex-start; margin-bottom: 10px;
        background: #f8fafc; border: 1px solid var(--bn-border); border-radius: 10px; padding: 12px;
    }
    .bn-stop-row .seq {
        flex: 0 0 26px; height: 26px; border-radius: 50%; background: var(--bn-blue); color: #fff;
        display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; margin-top: 6px;
    }
    .bn-stop-row .grow { flex: 1 1 auto; }
    .bn-stop-row .bn-control { margin-bottom: 6px; }
    .bn-stop-actions { display: flex; flex-direction: column; gap: 4px; }
    .bn-mini-btn {
        border: 1px solid #cfd9e5; background: #fff; border-radius: 7px; width: 30px; height: 28px;
        font-size: 12px; color: #475569; cursor: pointer;
    }
    .bn-mini-btn:hover { background: #eef3f8; }
    .bn-mini-btn.danger { color: var(--bn-red); border-color: #f3c2c2; }

    .bn-add-stop {
        display: inline-flex; align-items: center; gap: 7px; border: 1px dashed var(--bn-blue);
        background: #eff5ff; color: var(--bn-blue); border-radius: 9px; padding: 9px 14px;
        font-size: 12px; font-weight: 800; cursor: pointer;
    }
    .bn-add-stop:hover { background: #e0ecff; }

    .bn-recalc-btn {
        display: inline-flex; align-items: center; gap: 8px; border: 0; border-radius: 9px;
        background: #0b1d36; color: #fff; padding: 10px 16px; font-size: 12px; font-weight: 800; cursor: pointer;
    }
    .bn-recalc-btn:disabled { opacity: .6; cursor: wait; }

    .bn-compare {
        display: none; margin-top: 14px; border-radius: 10px; overflow: hidden; border: 1px solid var(--bn-border);
    }
    .bn-compare table { width: 100%; margin: 0; font-size: 12.5px; }
    .bn-compare th, .bn-compare td { padding: 10px 14px; border-bottom: 1px solid #edf1f5; }
    .bn-compare th { background: #fbfcfe; text-align: left; font-weight: 800; color: #53657d; width: 34%; }
    .bn-compare .up { color: var(--bn-red); font-weight: 800; }
    .bn-compare .down { color: var(--bn-green); font-weight: 800; }
    .bn-compare .same { color: var(--bn-muted); }

    .bn-warn-min {
        display: none; margin-top: 14px; background: var(--bn-orange-light, #fff7e6);
        border: 1px solid #f0c26b; border-left: 5px solid var(--bn-orange); border-radius: 10px; padding: 14px 16px;
    }
    .bn-warn-min h6 { margin: 0 0 4px; font-size: 13px; font-weight: 800; color: #92400e; }
    .bn-warn-min p { margin: 0; font-size: 12px; color: #7c4a03; }

    .bn-confirm-box {
        display: none; margin-top: 12px; background: #fff1f1; border: 1px solid #f3c2c2;
        border-radius: 10px; padding: 12px 14px; font-size: 12.5px; font-weight: 700; color: #b91c1c;
    }
    .bn-confirm-box label { display: flex; gap: 8px; align-items: flex-start; margin: 0; cursor: pointer; }

    .bn-actions-bar {
        position: sticky; bottom: 0; background: #fff; border: 1px solid var(--bn-border); border-radius: 14px;
        padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px;
        box-shadow: 0 -6px 22px rgba(31,52,73,.10); flex-wrap: wrap;
    }
    .bn-save-btn {
        min-width: 170px; min-height: 46px; border: 0; border-radius: 10px;
        background: linear-gradient(135deg, var(--bn-blue), var(--bn-blue-dark)); color: #fff;
        font-size: 13px; font-weight: 800; box-shadow: 0 5px 15px rgba(7,87,217,.22); cursor: pointer;
    }
    .bn-save-btn:hover { transform: translateY(-1px); }

    /* timeline (audit log) */
    .bn-timeline { position: relative; margin-left: 6px; padding-left: 26px; border-left: 2px solid #dbeafe; }
    .bn-timeline-item {
        position: relative; margin-bottom: 16px; padding: 13px 15px; background: #f8fafc;
        border: 1px solid #e6edf5; border-radius: 10px;
    }
    .bn-timeline-item:last-child { margin-bottom: 0; }
    .bn-timeline-dot {
        position: absolute; left: -34px; top: 16px; width: 12px; height: 12px; border-radius: 50%;
        background: var(--bn-blue); border: 3px solid #fff; box-shadow: 0 0 0 2px #bfdbfe;
    }
    .bn-timeline-time { font-size: 10px; color: #64748b; font-weight: 700; }
    .bn-timeline-event { margin-top: 4px; font-size: 12.5px; color: var(--bn-text); font-weight: 800; }
    .bn-timeline-details { margin-top: 3px; font-size: 11px; color: #64748b; line-height: 1.5; word-break: break-word; }

    .pac-container { z-index: 3000 !important; }

    @media (max-width: 767px) {
        #content { padding: 14px !important; }
        .bn-section-body { padding: 15px; }
    }
</style>

<div class="wrapper">
<div id="content">
<div class="bn-edit-wrapper">

    <div class="bn-page-header">
        <div class="bn-page-title">
            <div class="bn-page-icon"><i class="fas fa-taxi"></i></div>
            <div>
                <h2>Manage Booking</h2>
                <p>Edit every detail of this booking — changes are saved and logged</p>
            </div>
        </div>
        <div class="bn-header-actions">
            <span class="bn-booking-ref"><i class="fas fa-hashtag"></i> {{ $data->booking_id }}</span>
            <a href="{{ route('admbook.show', $data->id) }}" class="bn-ghost-btn"><i class="fas fa-eye"></i> View</a>
            <a href="{{ route('admbook.index') }}" class="bn-ghost-btn"><i class="fas fa-arrow-left"></i> All bookings</a>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success bn-alert alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger bn-alert alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session()->get('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger bn-alert" role="alert">
            <strong><i class="fas fa-exclamation-triangle mr-2"></i>Please fix the following:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admbook.update', $data->id) }}" method="POST" id="bookingEditForm">
        @method('PATCH')
        @csrf

        <input type="hidden" name="original_price" value="{{ (float) $data->price }}">
        <input type="hidden" name="distance" id="distanceInput" value="{{ (float) $data->distance }}">
        <input type="hidden" name="duration_minutes" id="durationInput" value="{{ (int) $data->duration_minutes }}">

        {{-- ============================ CUSTOMER ============================ --}}
        <div class="bn-section">
            <div class="bn-section-head"><i class="fas fa-user-circle"></i><h4>Customer Details</h4></div>
            <div class="bn-section-body">
                <div class="row">
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-user"></i> Name</label>
                        <input type="text" name="name" class="bn-control" value="{{ old('name', $data->name) }}" required>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-phone"></i> Phone</label>
                        <input type="text" name="phone" class="bn-control" value="{{ old('phone', $data->phone) }}" required>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" name="email" class="bn-control" value="{{ old('email', $data->email) }}" required>
                    </div></div>
                </div>
            </div>
        </div>

        {{-- ============================ JOURNEY ============================ --}}
        <div class="bn-section">
            <div class="bn-section-head">
                <i class="fas fa-route"></i><h4>Journey Details</h4>
                <span class="bn-hint">Pickup → Stop 1 → Stop 2 → … → Destination</span>
            </div>
            <div class="bn-section-body">

                <div class="bn-fg">
                    <label class="bn-label"><i class="fas fa-map-marker-alt"></i> Pickup address</label>
                    <input type="text" name="pickup" id="pickupInput" class="bn-control bn-place" autocomplete="off"
                           value="{{ old('pickup', $data->pickup) }}" required>
                </div>

                <label class="bn-label"><i class="fas fa-flag"></i> Stops</label>
                <div id="stopsWrap">
                    @foreach(old('stops', $stops->map(fn($s) => ['id' => $s->id, 'address' => $s->address, 'notes' => $s->notes])->all()) as $i => $s)
                        <div class="bn-stop-row" data-stop>
                            <div class="seq">{{ $i + 1 }}</div>
                            <div class="grow">
                                <input type="hidden" name="stops[{{ $i }}][id]" value="{{ $s['id'] ?? '' }}">
                                <input type="text" name="stops[{{ $i }}][address]" class="bn-control bn-place"
                                       placeholder="Stop address" autocomplete="off" value="{{ $s['address'] ?? '' }}">
                                <input type="text" name="stops[{{ $i }}][notes]" class="bn-control"
                                       placeholder="Optional note for this stop" value="{{ $s['notes'] ?? '' }}">
                            </div>
                            <div class="bn-stop-actions">
                                <button type="button" class="bn-mini-btn" data-move="up" title="Move up"><i class="fas fa-arrow-up"></i></button>
                                <button type="button" class="bn-mini-btn" data-move="down" title="Move down"><i class="fas fa-arrow-down"></i></button>
                                <button type="button" class="bn-mini-btn danger" data-remove title="Remove stop"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="bn-add-stop" id="addStopBtn"><i class="fas fa-plus"></i> Add stop</button>

                <div class="bn-fg mt-3">
                    <label class="bn-label"><i class="fas fa-map-pin"></i> Destination address</label>
                    <input type="text" name="dropoff" id="dropoffInput" class="bn-control bn-place" autocomplete="off"
                           value="{{ old('dropoff', $data->dropoff) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label"><i class="far fa-calendar-alt"></i> Pickup date</label>
                        <input type="date" name="pickup_date" class="bn-control" value="{{ old('pickup_date', $data->pickup_date) }}">
                    </div></div>
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label"><i class="far fa-clock"></i> Pickup time</label>
                        <input type="time" name="pickup_time" class="bn-control" value="{{ old('pickup_time', $data->pickup_time) }}">
                    </div></div>
                    <div class="col-md-6"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-exchange-alt"></i> Return journey</label>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <label style="margin:0; display:flex; gap:6px; align-items:center; font-weight:700; font-size:12px;">
                                <input type="checkbox" name="is_return" id="isReturn" value="1" {{ old('is_return', $data->is_return) == 1 ? 'checked' : '' }}>
                                This is a return trip
                            </label>
                        </div>
                    </div></div>
                </div>
                <div class="row" id="returnFields" style="{{ old('is_return', $data->is_return) == 1 ? '' : 'display:none;' }}">
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label"><i class="far fa-calendar-check"></i> Return date</label>
                        <input type="date" name="return_date" class="bn-control" value="{{ old('return_date', $data->return_date) }}">
                    </div></div>
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label"><i class="far fa-clock"></i> Return time</label>
                        <input type="time" name="return_time" class="bn-control" value="{{ old('return_time', $data->return_time) }}">
                    </div></div>
                </div>

                <div class="bn-readout">
                    <div class="item">Distance <b id="distanceReadout">{{ $data->distance ? number_format((float)$data->distance, 2) . ' mi' : '—' }}</b></div>
                    <div class="item">Est. journey time <b id="durationReadout">{{ $data->duration_minutes ? \App\Services\RouteService::humanDuration((int)$data->duration_minutes) : '—' }}</b></div>
                    <div class="item">Current price <b>£{{ number_format((float) $data->price, 2) }}</b></div>
                </div>

                <button type="button" class="bn-recalc-btn" id="recalcBtn">
                    <i class="fas fa-calculator"></i> Recalculate route &amp; price
                </button>
                <span id="recalcMsg" style="font-size:12px; color:var(--bn-muted); margin-left:10px;"></span>

                <div class="bn-compare" id="comparePanel">
                    <table>
                        <tr><th></th><th>Previous</th><th>New</th></tr>
                        <tr><th>Distance</th><td id="cmpPrevDist">—</td><td id="cmpNewDist">—</td></tr>
                        <tr><th>Journey time</th><td id="cmpPrevDur">—</td><td id="cmpNewDur">—</td></tr>
                        <tr><th>Price</th><td id="cmpPrevPrice">—</td><td id="cmpNewPrice">—</td></tr>
                    </table>
                </div>

                <div class="bn-warn-min" id="minWarn" @if($isBelowMin && $minEnforced) style="display:block;" @endif>
                    <h6><i class="fas fa-exclamation-triangle"></i> Below minimum booking distance</h6>
                    <p id="minWarnText">@if($isBelowMin) This journey is {{ number_format($currentDistance, 1) }} miles. Minimum is {{ rtrim(rtrim(number_format($minMiles, 1), '0'), '.') }} miles. Tick the override below with a reason to save. @endif</p>
                </div>

                <div class="bn-confirm-box" id="overrideBox" @if($isBelowMin && $minEnforced) style="display:block;" @endif>
                    <label>
                        <input type="checkbox" name="min_distance_override" id="overrideChk" value="1"
                               {{ old('min_distance_override', $data->min_distance_override) ? 'checked' : '' }}>
                        <span>Override the minimum distance restriction for this booking (exceptional circumstances).</span>
                    </label>
                    <input type="text" name="min_distance_override_reason" class="bn-control mt-2"
                           placeholder="Reason for override (recorded in the audit log)"
                           value="{{ old('min_distance_override_reason', $data->min_distance_override_reason) }}">
                    @if($data->min_distance_override)
                        <div style="margin-top:6px; font-weight:600; color:#7c4a03;">
                            Currently overridden by {{ $data->min_distance_override_by }}
                            @if($data->min_distance_override_at) on {{ \Carbon\Carbon::parse($data->min_distance_override_at)->format('d M Y H:i') }} @endif
                        </div>
                    @endif
                </div>

                <div class="bn-confirm-box" id="priceConfirmBox">
                    <label>
                        <input type="checkbox" name="price_change_confirmed" id="priceConfirmChk" value="1">
                        <span id="priceConfirmText">Confirm the price change before saving.</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- ============================ FLIGHT ============================ --}}
        <div class="bn-section">
            <div class="bn-section-head"><i class="fas fa-plane"></i><h4>Flight Details</h4><span class="bn-hint">Airport bookings only</span></div>
            <div class="bn-section-body">
                <div class="row">
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label">Flight number</label>
                        <input type="text" name="flight_number" class="bn-control" value="{{ old('flight_number', $data->flight_number) }}">
                    </div></div>
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label">Airline</label>
                        <input type="text" name="airline" class="bn-control" value="{{ old('airline', $data->airline) }}">
                    </div></div>
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label">Airport</label>
                        <input type="text" name="flight_airport" class="bn-control" value="{{ old('flight_airport', $data->flight_airport) }}">
                    </div></div>
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label">Direction</label>
                        <input type="text" name="flight_direction" class="bn-control" value="{{ old('flight_direction', $data->flight_direction) }}" placeholder="Arrival / Departure">
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label">Origin / destination</label>
                        <input type="text" name="flight_origin_destination" class="bn-control" value="{{ old('flight_origin_destination', $data->flight_origin_destination) }}">
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label">Scheduled time</label>
                        <input type="text" name="flight_scheduled_time" class="bn-control" value="{{ old('flight_scheduled_time', $data->flight_scheduled_time) }}">
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label">Arrival time</label>
                        <input type="text" name="flight_arrival_time" class="bn-control" value="{{ old('flight_arrival_time', $data->flight_arrival_time) }}">
                    </div></div>
                </div>
            </div>
        </div>

        {{-- ============================ VEHICLE ============================ --}}
        <div class="bn-section">
            <div class="bn-section-head"><i class="fas fa-car-side"></i><h4>Vehicle Details</h4></div>
            <div class="bn-section-body">
                <div class="row">
                    <div class="col-md-6"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-car"></i> Vehicle type</label>
                        <select name="car_id" id="carSelect" class="bn-control">
                            <option value="">— Not assigned —</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}" {{ old('car_id', $data->car_id) == $car->id ? 'selected' : '' }}>
                                    {{ $car->name }}{{ $car->call_for_quote ? ' (quote on request)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div></div>
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-users"></i> Passengers</label>
                        <input type="number" name="passengers" class="bn-control" min="1" max="50" value="{{ old('passengers', $data->passengers) }}">
                    </div></div>
                    <div class="col-md-3"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-suitcase"></i> Luggage (bags)</label>
                        <input type="number" name="bags" class="bn-control" min="0" max="99" value="{{ old('bags', $data->bags) }}">
                    </div></div>
                </div>
            </div>
        </div>

        {{-- ============================ PAYMENT ============================ --}}
        <div class="bn-section">
            <div class="bn-section-head"><i class="fas fa-credit-card"></i><h4>Payment Details</h4>
                <span class="bn-hint">Method = how they pay · Status = whether it is paid</span>
            </div>
            <div class="bn-section-body">
                <div class="row">
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-wallet"></i> Payment method</label>
                        <select name="payment_method" class="bn-control">
                            @foreach($paymentMethods as $key => $label)
                                <option value="{{ $key }}" {{ old('payment_method', $data->payment_method) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-check-circle"></i> Payment status</label>
                        <select name="payment_status" class="bn-control">
                            @foreach($paymentStatuses as $key => $label)
                                <option value="{{ $key }}" {{ old('payment_status', $data->payment_status) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-pound-sign"></i> Total booking amount</label>
                        <input type="number" step="0.01" min="0" name="price" id="priceInput" class="bn-control" value="{{ old('price', (float) $data->price) }}" required>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-hand-holding-usd"></i> Amount paid</label>
                        <input type="number" step="0.01" min="0" name="amount_paid" id="amountPaidInput" class="bn-control" value="{{ old('amount_paid', (float) $data->amount_paid) }}">
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-balance-scale"></i> Outstanding balance</label>
                        <input type="text" id="outstandingReadout" class="bn-control" readonly value="£{{ number_format($data->outstandingBalance(), 2) }}">
                    </div></div>
                </div>
                <p style="font-size:11.5px; color:var(--bn-muted); margin:0;">
                    <i class="fas fa-info-circle"></i>
                    Full manual payment tracking (payment date, confirmed by, payment notes) is on the booking view page.
                </p>
            </div>
        </div>

        {{-- ====================== BOOKING MANAGEMENT ====================== --}}
        <div class="bn-section">
            <div class="bn-section-head"><i class="fas fa-tasks"></i><h4>Booking Management</h4></div>
            <div class="bn-section-body">
                <div class="row">
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-traffic-light"></i> Booking status</label>
                        <select name="status" class="bn-control">
                            @foreach($bookingStatuses as $st)
                                <option value="{{ $st }}" {{ old('status', $data->status) === $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-inbox"></i> Booking source</label>
                        <select name="source" class="bn-control">
                            @foreach($sources as $key => $label)
                                <option value="{{ $key }}" {{ old('source', $data->source ?: 'web') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-user-tie"></i> Driver assignment</label>
                        <select name="driver_id" class="bn-control">
                            <option value="">— Unassigned —</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ old('driver_id', $data->driver_id) == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                            @endforeach
                        </select>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-comment-dots"></i> Customer notes</label>
                        <textarea name="special_instructions" data-no-richtext class="bn-control">{{ old('special_instructions', $data->special_instructions) }}</textarea>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-lock"></i> Internal notes</label>
                        <textarea name="internal_notes" data-no-richtext class="bn-control">{{ old('internal_notes', $data->internal_notes) }}</textarea>
                    </div></div>
                    <div class="col-md-4"><div class="bn-fg">
                        <label class="bn-label"><i class="fas fa-id-badge"></i> Driver notes</label>
                        <textarea name="driver_notes" data-no-richtext class="bn-control">{{ old('driver_notes', $data->driver_notes) }}</textarea>
                    </div></div>
                </div>
            </div>
        </div>

        <div class="bn-actions-bar">
            <div style="font-size:12px; color:var(--bn-muted);">
                <i class="fas fa-shield-alt" style="color:var(--bn-blue);"></i>
                All changes are recorded in the booking audit log.
            </div>
            <button type="submit" class="bn-save-btn"><i class="fas fa-save mr-1"></i> Save changes</button>
        </div>
    </form>

    {{-- ============================ AUDIT LOG ============================ --}}
    <div class="bn-section" style="margin-top:20px;">
        <div class="bn-section-head"><i class="fas fa-history"></i><h4>Booking Audit Log</h4></div>
        <div class="bn-section-body">
            @if($data->timeline && is_array($data->timeline) && count($data->timeline) > 0)
                <div class="bn-timeline">
                    @foreach(array_reverse($data->timeline) as $log)
                        <div class="bn-timeline-item">
                            <div class="bn-timeline-dot"></div>
                            <div class="bn-timeline-time">
                                <i class="far fa-clock"></i> {{ $log['timestamp'] ?? '' }} &nbsp;•&nbsp; {{ $log['actor'] ?? 'System' }}
                            </div>
                            <div class="bn-timeline-event">{{ $log['event'] ?? '' }}</div>
                            @if(!empty($log['details']))
                                <div class="bn-timeline-details">{{ $log['details'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding:25px; color:#94a3b8;">
                    <i class="fas fa-history" style="font-size:26px;"></i>
                    <div style="margin-top:8px;">No changes logged yet.</div>
                </div>
            @endif
        </div>
    </div>

</div>
</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script>
<script>
(function () {
    const CSRF = document.querySelector('#bookingEditForm input[name=_token]').value;
    const RECALC_URL = "{{ route('admin.book.recalculate', $data->id) }}";
    const ORIGINAL_PRICE = parseFloat(document.querySelector('input[name=original_price]').value || '0');

    /* ---------- Google Places autocomplete ---------- */
    function attachPlaces(input) {
        if (!input || input.dataset.placesBound) return;
        input.dataset.placesBound = '1';
        if (typeof google === 'undefined' || !google.maps || !google.maps.places) return;
        const ac = new google.maps.places.Autocomplete(input, {
            componentRestrictions: { country: 'gb' },
            fields: ['formatted_address', 'name'],
        });
        ac.addListener('place_changed', function () {
            const p = ac.getPlace();
            input.value = p.formatted_address || p.name || input.value;
        });
        input.addEventListener('keydown', function (e) { if (e.key === 'Enter') e.preventDefault(); });
    }
    function bindAllPlaces() { document.querySelectorAll('.bn-place').forEach(attachPlaces); }
    bindAllPlaces();

    /* ---------- Return fields toggle ---------- */
    const isReturn = document.getElementById('isReturn');
    isReturn.addEventListener('change', function () {
        document.getElementById('returnFields').style.display = this.checked ? '' : 'none';
    });

    /* ---------- Stops management ---------- */
    const stopsWrap = document.getElementById('stopsWrap');

    function reindexStops() {
        stopsWrap.querySelectorAll('[data-stop]').forEach(function (row, idx) {
            row.querySelector('.seq').textContent = idx + 1;
            row.querySelector('input[name$="[id]"]').name = 'stops[' + idx + '][id]';
            row.querySelector('input[name$="[address]"]').name = 'stops[' + idx + '][address]';
            row.querySelector('input[name$="[notes]"]').name = 'stops[' + idx + '][notes]';
        });
    }

    function makeStopRow() {
        const row = document.createElement('div');
        row.className = 'bn-stop-row';
        row.setAttribute('data-stop', '');
        row.innerHTML =
            '<div class="seq"></div>' +
            '<div class="grow">' +
                '<input type="hidden" name="stops[x][id]" value="">' +
                '<input type="text" name="stops[x][address]" class="bn-control bn-place" placeholder="Stop address" autocomplete="off">' +
                '<input type="text" name="stops[x][notes]" class="bn-control" placeholder="Optional note for this stop">' +
            '</div>' +
            '<div class="bn-stop-actions">' +
                '<button type="button" class="bn-mini-btn" data-move="up"><i class="fas fa-arrow-up"></i></button>' +
                '<button type="button" class="bn-mini-btn" data-move="down"><i class="fas fa-arrow-down"></i></button>' +
                '<button type="button" class="bn-mini-btn danger" data-remove><i class="fas fa-times"></i></button>' +
            '</div>';
        return row;
    }

    document.getElementById('addStopBtn').addEventListener('click', function () {
        const row = makeStopRow();
        stopsWrap.appendChild(row);
        reindexStops();
        attachPlaces(row.querySelector('.bn-place'));
    });

    stopsWrap.addEventListener('click', function (e) {
        const btn = e.target.closest('button');
        if (!btn) return;
        const row = btn.closest('[data-stop]');
        if (btn.hasAttribute('data-remove')) {
            row.remove();
            reindexStops();
        } else if (btn.dataset.move === 'up' && row.previousElementSibling) {
            row.parentNode.insertBefore(row, row.previousElementSibling);
            reindexStops();
        } else if (btn.dataset.move === 'down' && row.nextElementSibling) {
            row.parentNode.insertBefore(row.nextElementSibling, row);
            reindexStops();
        }
    });

    /* ---------- Recalculate ---------- */
    const recalcBtn = document.getElementById('recalcBtn');
    const recalcMsg = document.getElementById('recalcMsg');
    const comparePanel = document.getElementById('comparePanel');
    const minWarn = document.getElementById('minWarn');
    const minWarnText = document.getElementById('minWarnText');
    const overrideBox = document.getElementById('overrideBox');
    const priceConfirmBox = document.getElementById('priceConfirmBox');
    const priceConfirmChk = document.getElementById('priceConfirmChk');
    const priceInput = document.getElementById('priceInput');

    function fmtMiles(v) { return (v || v === 0) ? Number(v).toFixed(2) + ' mi' : '—'; }
    function fmtMoney(v) { return (v || v === 0) ? '£' + Number(v).toFixed(2) : '—'; }
    function cls(oldV, newV) { if (newV > oldV) return 'up'; if (newV < oldV) return 'down'; return 'same'; }

    function collectStops() {
        return Array.from(stopsWrap.querySelectorAll('[data-stop]')).map(function (row, idx) {
            return {
                index: idx,
                address: row.querySelector('input[name$="[address]"]').value.trim(),
            };
        }).filter(function (s) { return s.address !== ''; });
    }

    recalcBtn.addEventListener('click', function () {
        recalcBtn.disabled = true;
        recalcMsg.textContent = 'Calculating…';

        const fd = new FormData();
        fd.append('_token', CSRF);
        fd.append('pickup', document.getElementById('pickupInput').value);
        fd.append('dropoff', document.getElementById('dropoffInput').value);
        fd.append('car_id', document.getElementById('carSelect').value);
        fd.append('is_return', isReturn.checked ? 1 : 0);
        collectStops().forEach(function (s, i) { fd.append('stops[' + i + '][address]', s.address); });

        fetch(RECALC_URL, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                recalcBtn.disabled = false;
                if (!d.ok) {
                    recalcMsg.textContent = d.route_error || 'Could not calculate this route.';
                    return;
                }
                recalcMsg.textContent = 'Updated ' + new Date().toLocaleTimeString();

                document.getElementById('distanceInput').value = d.distance;
                document.getElementById('durationInput').value = d.duration_minutes;
                document.getElementById('distanceReadout').textContent = fmtMiles(d.distance);
                document.getElementById('durationReadout').textContent = d.duration_human;

                // comparison
                comparePanel.style.display = 'block';
                const pv = d.previous;
                document.getElementById('cmpPrevDist').textContent = fmtMiles(pv.distance);
                document.getElementById('cmpNewDist').textContent = fmtMiles(d.distance);
                document.getElementById('cmpNewDist').className = cls(pv.distance, d.distance);
                document.getElementById('cmpPrevDur').textContent = pv.duration_minutes ? pv.duration_minutes + ' min' : '—';
                document.getElementById('cmpNewDur').textContent = d.duration_human;

                let newPrice = d.call_for_quote ? null : d.price;
                document.getElementById('cmpPrevPrice').textContent = fmtMoney(pv.price);
                document.getElementById('cmpNewPrice').textContent = d.call_for_quote ? 'Quote on request' : fmtMoney(newPrice);
                if (newPrice !== null) {
                    document.getElementById('cmpNewPrice').className = cls(pv.price, newPrice);
                    priceInput.value = Number(newPrice).toFixed(2);
                    updateOutstanding();
                }

                // minimum distance
                if (d.minimum && d.minimum.below_minimum) {
                    minWarn.style.display = 'block';
                    minWarnText.textContent = 'This journey is ' + Number(d.distance).toFixed(1) +
                        ' miles. Minimum is ' + d.minimum.minimum_miles + ' miles. ' +
                        (d.minimum.enforced ? 'Tick the override below with a reason to save.' : '');
                    if (d.minimum.enforced) overrideBox.style.display = 'block';
                } else {
                    minWarn.style.display = 'none';
                    overrideBox.style.display = 'none';
                }

                maybeShowPriceConfirm();
            })
            .catch(function () {
                recalcBtn.disabled = false;
                recalcMsg.textContent = 'Recalculation failed. Try again.';
            });
    });

    /* ---------- Outstanding balance live ---------- */
    const amountPaidInput = document.getElementById('amountPaidInput');
    const outstandingReadout = document.getElementById('outstandingReadout');
    function updateOutstanding() {
        const bal = Math.max((parseFloat(priceInput.value) || 0) - (parseFloat(amountPaidInput.value) || 0), 0);
        outstandingReadout.value = '£' + bal.toFixed(2);
    }
    priceInput.addEventListener('input', function () { updateOutstanding(); maybeShowPriceConfirm(); });
    amountPaidInput.addEventListener('input', updateOutstanding);

    /* ---------- Price-change confirmation ---------- */
    function maybeShowPriceConfirm() {
        const cur = parseFloat(priceInput.value) || 0;
        if (Math.abs(cur - ORIGINAL_PRICE) >= 0.005) {
            priceConfirmBox.style.display = 'block';
            document.getElementById('priceConfirmText').textContent =
                'Price changes from £' + ORIGINAL_PRICE.toFixed(2) + ' to £' + cur.toFixed(2) + ' — tick to confirm.';
        } else {
            priceConfirmBox.style.display = 'none';
            priceConfirmChk.checked = false;
        }
    }

    /* ---------- Submit guards ---------- */
    document.getElementById('bookingEditForm').addEventListener('submit', function (e) {
        // drop any stop rows left blank so they don't trip validation
        stopsWrap.querySelectorAll('[data-stop]').forEach(function (row) {
            if (row.querySelector('input[name$="[address]"]').value.trim() === '') row.remove();
        });
        reindexStops();

        const cur = parseFloat(priceInput.value) || 0;
        if (Math.abs(cur - ORIGINAL_PRICE) >= 0.005 && !priceConfirmChk.checked) {
            e.preventDefault();
            priceConfirmBox.style.display = 'block';
            priceConfirmBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            alert('The price has changed. Please tick "Confirm price change" before saving.');
            return;
        }

        if (overrideBox.style.display === 'block') {
            const chk = document.getElementById('overrideChk');
            const reason = document.querySelector('input[name=min_distance_override_reason]');
            if (chk.checked && !reason.value.trim()) {
                e.preventDefault();
                reason.focus();
                alert('Please give a reason for overriding the minimum distance.');
            }
        }
    });

    /* initial state */
    reindexStops();
    maybeShowPriceConfirm();
})();
</script>
