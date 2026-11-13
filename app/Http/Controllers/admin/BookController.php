<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
use App\Models\BookingStop;
use App\Models\Cars;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMail;
use App\Services\BookingPricingService;
use App\Services\RouteService;
use Carbon\Carbon;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Abandoned card checkouts must never sit in the list as pending, even
        // if the scheduled clean-up has not run yet.
        try {
            app(\App\Services\CardPaymentService::class)->cancelAbandoned();
        } catch (\Throwable $e) {
            report($e);
        }

        $query =Book::leftJoin('users', 'books.user_id', '=', 'users.id')
            ->select('books.*', 'users.name as username', 'users.phone as userphone', 'users.address as useraddress');

        $filter = request('filter');
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        switch ($filter) {
            case 'pending':
                $query->where('books.status', 'PENDING APPROVAL');
                break;
            case 'confirmed':
                $query->where('books.status', 'CONFIRMED');
                break;
            case 'rejected':
                $query->where('books.status', 'REJECTED');
                break;
            case 'cancelled':
                $query->where('books.status', 'CANCELLED');
                break;
            case 'completed':
                $query->where('books.status', 'COMPLETED');
                break;
            case 'today':
                $query->whereDate('books.pickup_date', $today);
                break;
            case 'tomorrow':
                $query->whereDate('books.pickup_date', $tomorrow);
                break;
            case 'airport':
                $query->where(function($q) {
                    $q->whereNotNull('books.flight_number')
                      ->orWhereNotNull('books.flight_airport')
                      ->orWhere('books.pickup', 'like', '%airport%')
                      ->orWhere('books.dropoff', 'like', '%airport%');
                });
                break;
            case 'online':
                $query->where('books.payment_method', 'stripe');
                break;
            case 'cash':
                $query->whereIn('books.payment_method', ['pay_in_car_cash', 'pay_in_car_card']);
                break;
            case 'paid':
                $query->where('books.payment_status', 'paid');
                break;
            case 'unpaid':
                $query->whereIn('books.payment_status', ['unpaid', 'pending_payment', 'partially_paid', 'payment_failed']);
                break;
            case 'partially_paid':
                $query->where('books.payment_status', 'partially_paid');
                break;
            case 'src_web':
                $query->where('books.source', 'web');
                break;
            case 'src_admin':
                $query->where('books.source', 'admin');
                break;
            case 'src_phone':
                $query->where('books.source', 'phone');
                break;
            case 'urgent':
                // Urgent: pending approval and pickup date/time is within 2 hours
                $urgentThreshold = Carbon::now()->addHours(2);
                $query->where('books.status', 'PENDING APPROVAL')
                      ->where(function($q) use ($urgentThreshold) {
                          $q->whereDate('books.pickup_date', '<', $urgentThreshold->toDateString())
                            ->orWhere(function($sub) use ($urgentThreshold) {
                                $sub->whereDate('books.pickup_date', $urgentThreshold->toDateString())
                                   ->whereTime('books.pickup_time', '<=', $urgentThreshold->toTimeString());
                            });
                      });
                break;
        }

        $data['data'] = $query->orderBy('books.created_at', 'desc')->get();
        
        foreach ($data['data'] as $value) {
            if (!empty($value['addons'])) {
                $value['addonssoft'] = unserialize($value['addons']);
            }
        }

        $data['driver'] = User::where(['type' => 2])->get();
        $data['current_filter'] = $filter;
        return view('admin.book.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['data'] = Book::findOrFail($id);
        $data['drivers'] = User::where('type', 2)->get();
        return view('admin.book.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['data'] = Book::with('stops')->findOrFail($id);
        $data['drivers'] = User::where('type', 2)->orderBy('name')->get();
        $data['cars'] = Cars::orderBy('sort_order', 'asc')->get();
        $data['paymentMethods'] = Book::PAYMENT_METHODS;
        $data['paymentStatuses'] = Book::PAYMENT_STATUSES;
        $data['bookingStatuses'] = Book::BOOKING_STATUSES;
        $data['sources'] = Book::SOURCES;
        return view('admin.book.edit')->with($data);
    }

    /**
     * AJAX: recalculate route distance / duration / fare for the addresses
     * currently entered in the edit form, WITHOUT saving anything.
     */
    public function recalculate(Request $request, BookingPricingService $pricing, string $id)
    {
        $book = Book::findOrFail($id);

        $stops = collect($request->input('stops', []))
            ->map(fn ($s) => is_array($s) ? trim($s['address'] ?? '') : trim((string) $s))
            ->filter()
            ->values()
            ->all();

        $quote = $pricing->quote([
            'pickup'      => $request->input('pickup', $book->pickup),
            'dropoff'     => $request->input('dropoff', $book->dropoff),
            'stops'       => $stops,
            'is_return'   => $request->boolean('is_return'),
            'only_car_id' => $request->input('car_id') ?: $book->car_id,
        ]);

        $car = $quote['cars'][0] ?? null;
        $callForQuote = $car ? (bool) $car->call_for_quote : false;
        $newPrice = ($car && !$callForQuote) ? round((float) $car->calculated_price, 2) : null;

        return response()->json([
            'ok'               => $quote['route']['ok'],
            'route_error'      => $quote['route']['error'],
            'distance'         => round((float) $quote['distance'], 2),
            'duration_minutes' => $quote['duration_minutes'],
            'duration_human'   => RouteService::humanDuration($quote['duration_minutes']),
            'price'            => $newPrice,
            'call_for_quote'   => $callForQuote,
            'legs'             => $quote['route']['legs'],
            'minimum'          => $quote['minimum'],
            'previous'         => [
                'distance'         => round((float) $book->distance, 2),
                'price'            => round((float) $book->price, 2),
                'duration_minutes' => (int) $book->duration_minutes,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookingPricingService $pricing, RouteService $routes, string $id)
    {
        $book = Book::with('stops')->findOrFail($id);

        $validated = $request->validate([
            'name'                        => 'required|string|max:255',
            'email'                       => 'required|email|max:255',
            'phone'                       => 'required|string|max:50',

            'pickup'                      => 'required|string|max:500',
            'dropoff'                     => 'required|string|max:500',
            'pickup_date'                 => 'nullable|date',
            'pickup_time'                 => 'nullable|string|max:20',
            'is_return'                   => 'nullable|boolean',
            'return_date'                 => 'nullable|date',
            'return_time'                 => 'nullable|string|max:20',
            'distance'                    => 'nullable|numeric|min:0',
            'duration_minutes'            => 'nullable|integer|min:0',

            'stops'                       => 'nullable|array',
            'stops.*.id'                  => 'nullable|integer',
            'stops.*.address'             => 'required_with:stops|string|max:500',
            'stops.*.notes'               => 'nullable|string|max:500',

            'car_id'                      => 'nullable|exists:cars,id',
            'passengers'                  => 'nullable|integer|min:1|max:50',
            'bags'                        => 'nullable|integer|min:0|max:99',

            'flight_number'               => 'nullable|string|max:50',
            'airline'                     => 'nullable|string|max:100',
            'flight_airport'              => 'nullable|string|max:150',
            'flight_direction'            => 'nullable|string|max:50',
            'flight_origin_destination'   => 'nullable|string|max:150',
            'flight_scheduled_time'       => 'nullable|string|max:100',
            'flight_arrival_time'         => 'nullable|string|max:100',

            'special_instructions'        => 'nullable|string',
            'internal_notes'              => 'nullable|string',
            'driver_notes'                => 'nullable|string',

            'status'                      => 'required|string|in:' . implode(',', Book::BOOKING_STATUSES),
            'source'                      => 'nullable|string|in:' . implode(',', array_keys(Book::SOURCES)),
            'driver_id'                   => 'nullable|exists:users,id',

            'payment_method'              => 'required|string|in:' . implode(',', array_keys(Book::PAYMENT_METHODS)),
            'payment_status'              => 'required|string|in:' . implode(',', array_keys(Book::PAYMENT_STATUSES)),
            'price'                       => 'required|numeric|min:0',
            'amount_paid'                 => 'nullable|numeric|min:0',

            'original_price'              => 'nullable|numeric',
            'price_change_confirmed'      => 'nullable|boolean',

            'min_distance_override'        => 'nullable|boolean',
            'min_distance_override_reason' => 'nullable|string|max:1000',
        ]);

        $actor = auth()->user()->name ?? 'Administrator';
        $incomingStops = collect($validated['stops'] ?? [])
            ->map(fn ($s) => [
                'id'      => $s['id'] ?? null,
                'address' => trim($s['address']),
                'notes'   => isset($s['notes']) ? trim($s['notes']) : null,
            ])
            ->values();

        $distance = (float) ($validated['distance'] ?? $book->distance);

        // --- 8-mile minimum distance rule -------------------------------------
        $minCheck = $pricing->minimumDistanceCheck($distance);
        $wantsOverride = $request->boolean('min_distance_override');

        if ($minCheck['enforced'] && $minCheck['below_minimum'] && !$wantsOverride && !$book->min_distance_override) {
            return redirect()->back()->withInput()->with(
                'error',
                'This journey is ' . number_format($distance, 1) . ' miles, below the minimum booking distance of '
                . rtrim(rtrim(number_format($minCheck['minimum_miles'], 1), '0'), '.') . ' miles. '
                . 'Tick "Override minimum distance" and give a reason to save this booking.'
            );
        }

        if ($minCheck['below_minimum'] && $wantsOverride && empty($validated['min_distance_override_reason']) && !$book->min_distance_override) {
            return redirect()->back()->withInput()->with(
                'error',
                'Please provide a reason for overriding the minimum distance restriction.'
            );
        }

        // --- price-change confirmation --------------------------------------
        $originalPrice = round((float) ($validated['original_price'] ?? $book->price), 2);
        $newPrice = round((float) $validated['price'], 2);

        if ($originalPrice !== $newPrice && !$request->boolean('price_change_confirmed')) {
            return redirect()->back()->withInput()->with(
                'error',
                'The price changed from £' . number_format($originalPrice, 2) . ' to £' . number_format($newPrice, 2)
                . '. Please tick "Confirm price change" to save.'
            );
        }

        // --- snapshot BEFORE for the audit log -----------------------------
        $before = $this->auditSnapshot($book);

        // --- scalar fields ------------------------------------------------
        $book->fill([
            'name'                      => $validated['name'],
            'email'                     => $validated['email'],
            'phone'                     => $validated['phone'],
            'pickup'                    => $validated['pickup'],
            'dropoff'                   => $validated['dropoff'],
            'pickup_date'               => $validated['pickup_date'] ?? null,
            'pickup_time'               => $validated['pickup_time'] ?? null,
            'is_return'                 => $request->boolean('is_return') ? 1 : 0,
            'return_date'               => $validated['return_date'] ?? null,
            'return_time'               => $validated['return_time'] ?? null,
            'distance'                  => $distance ?: null,
            'duration_minutes'          => $validated['duration_minutes'] ?? $book->duration_minutes,
            'car_id'                    => $validated['car_id'] ?? null,
            'passengers'                => $validated['passengers'] ?? null,
            'bags'                      => $validated['bags'] ?? null,
            'flight_number'             => $validated['flight_number'] ?? null,
            'airline'                   => $validated['airline'] ?? null,
            'flight_airport'            => $validated['flight_airport'] ?? null,
            'flight_direction'          => $validated['flight_direction'] ?? null,
            'flight_origin_destination' => $validated['flight_origin_destination'] ?? null,
            'flight_scheduled_time'     => $validated['flight_scheduled_time'] ?? null,
            'flight_arrival_time'       => $validated['flight_arrival_time'] ?? null,
            'special_instructions'      => $validated['special_instructions'] ?? null,
            'internal_notes'            => $validated['internal_notes'] ?? null,
            'driver_notes'              => $validated['driver_notes'] ?? null,
            'status'                    => $validated['status'],
            'source'                    => $validated['source'] ?? ($book->source ?: 'web'),
            'driver_id'                 => $validated['driver_id'] ?? null,
            'payment_method'            => $validated['payment_method'],
            'payment_status'            => $validated['payment_status'],
            'price'                     => $newPrice,
            'amount_paid'               => $validated['amount_paid'] ?? $book->amount_paid ?? 0,
        ]);

        $book->outstanding_amount = max($newPrice - (float) $book->amount_paid, 0);

        // --- geocode pickup / dropoff when they changed ------------------
        if ($book->isDirty('pickup')) {
            [$lat, $lng] = $routes->geocode($book->pickup);
            $book->from_lat = $lat ?: null;
            $book->from_lng = $lng ?: null;
        }
        if ($book->isDirty('dropoff')) {
            [$lat, $lng] = $routes->geocode($book->dropoff);
            $book->to_lat = $lat ?: null;
            $book->to_lng = $lng ?: null;
        }

        // --- minimum-distance override bookkeeping ----------------------
        $overrideJustSet = false;
        if ($minCheck['below_minimum'] && $wantsOverride && !$book->min_distance_override) {
            $book->min_distance_override = true;
            $book->min_distance_override_reason = $validated['min_distance_override_reason'] ?? null;
            $book->min_distance_override_by = $actor;
            $book->min_distance_override_at = now();
            $overrideJustSet = true;
        } elseif (!$minCheck['below_minimum'] && $book->min_distance_override) {
            // journey is now long enough; clear the override flag
            $book->min_distance_override = false;
        }

        $book->save();

        // --- sync stops + keep vias / distancearr in step --------------
        $stopChange = $this->syncStops($book, $incomingStops, $routes);

        $addresses = $book->fresh('stops')->routeAddresses();
        $book->vias = $addresses;
        $book->distancearr = $addresses;
        $book->save();

        // --- audit log --------------------------------------------------
        $after = $this->auditSnapshot($book->fresh('stops'));
        $changes = [];
        foreach ($before as $label => $oldVal) {
            $changes[$label] = ['from' => $oldVal, 'to' => $after[$label] ?? null];
        }
        if ($stopChange) {
            $changes['Stops'] = [
                'from' => implode(' → ', $stopChange['before']) ?: '—',
                'to'   => implode(' → ', $stopChange['after']) ?: '—',
            ];
        }
        $book->logChanges($changes, $actor, 'Booking details updated');

        if ($overrideJustSet) {
            $book->logTimeline(
                'Minimum Distance Overridden',
                'Journey of ' . number_format($distance, 1) . ' miles is below the '
                . rtrim(rtrim(number_format($minCheck['minimum_miles'], 1), '0'), '.') . '-mile minimum. Reason: '
                . ($book->min_distance_override_reason ?: 'not given'),
                $actor
            );
        }

        return redirect()->route('admbook.edit', $book->id)->with('success', 'Booking updated successfully.');
    }

    /**
     * Create / update / delete BookingStop rows to match the submitted list,
     * re-sequencing 1..n by submitted order. Returns before/after label lists
     * for the audit log, or null when nothing changed.
     */
    private function syncStops(Book $book, $incomingStops, RouteService $routes): ?array
    {
        $existing = $book->stops()->get()->keyBy('id');
        $beforeLabels = $existing->map(fn ($s) => $s->address)->values()->all();

        $keptIds = [];
        $seq = 1;

        foreach ($incomingStops as $row) {
            $address = $row['address'];
            if ($address === '') {
                continue;
            }

            $model = ($row['id'] && $existing->has($row['id']))
                ? $existing->get($row['id'])
                : new BookingStop(['book_id' => $book->id]);

            $addressChanged = $model->address !== $address;
            $model->address = $address;
            $model->notes = $row['notes'] ?: null;
            $model->sequence = $seq++;

            if ($addressChanged || !$model->exists) {
                [$lat, $lng] = $routes->geocode($address);
                $model->lat = $lat ?: null;
                $model->lng = $lng ?: null;
            }

            $model->book_id = $book->id;
            $model->save();
            $keptIds[] = $model->id;
        }

        $book->stops()->whereNotIn('id', $keptIds)->delete();

        $afterLabels = $book->stops()->orderBy('sequence')->pluck('address')->all();

        return $beforeLabels === $afterLabels ? null : ['before' => $beforeLabels, 'after' => $afterLabels];
    }

    /**
     * Human-readable snapshot of the fields we track in the audit log.
     */
    private function auditSnapshot(Book $book): array
    {
        return [
            'Customer name'  => $book->name,
            'Phone'          => $book->phone,
            'Email'          => $book->email,
            'Pickup'         => $book->pickup,
            'Destination'    => $book->dropoff,
            'Pickup date'    => $book->pickup_date,
            'Pickup time'    => $book->pickup_time,
            'Vehicle'        => optional($book->carDetail)->name ?? $book->car_id,
            'Passengers'     => $book->passengers,
            'Luggage'        => $book->bags,
            'Flight number'  => $book->flight_number,
            'Distance (mi)'  => $book->distance ? round((float) $book->distance, 2) : null,
            'Duration (min)' => $book->duration_minutes,
            'Price'          => $book->price !== null ? '£' . number_format((float) $book->price, 2) : null,
            'Amount paid'    => '£' . number_format((float) $book->amount_paid, 2),
            'Payment method' => Book::PAYMENT_METHODS[$book->payment_method] ?? $book->payment_method,
            'Payment status' => Book::PAYMENT_STATUSES[$book->payment_status] ?? $book->payment_status,
            'Booking status' => $book->status,
            'Booking source' => Book::SOURCES[$book->source] ?? $book->source,
            'Driver'         => optional($book->driver)->name,
            'Customer notes' => $book->special_instructions,
            'Internal notes' => $book->internal_notes,
            'Driver notes'   => $book->driver_notes,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data Deleted Successfully');
    }

    public function updbooking(){
        $data = request()->all();

        $arr = [];
        for ($i=0; $i < count($data['heading']); $i++) { 
            $bes = [
                $data['heading'][$i],
                $data['price'][$i]
            ];
            array_push($arr,$bes);
        }
        // dd($arr);
        $val['addons'] = serialize($arr);
        $id = $data['bookid'];
        Book::find($id)->update($val);
        return redirect()->back()->with('success', 'Data Updated Successfully');
    }

    public function confirm(Request $request, $id)
    {
        $booking = Book::findOrFail($id);
        $booking->status = 'CONFIRMED';
        $booking->confirmed_at = now();
        $booking->confirmed_by = auth()->id();
        $booking->save();

        $booking->logTimeline('Booking Confirmed', 'Booking request confirmed by administrator.', auth()->user()->name);

        try {
            Mail::to($booking->email)->send(new BookingMail($booking));
        } catch (\Exception $e) {
            // Log or ignore
        }

        return redirect()->back()->with('success', 'Booking Confirmed and Customer Notified.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $booking = Book::findOrFail($id);
        $reason = $request->input('rejection_reason');
        
        $booking->status = 'REJECTED';
        $booking->rejection_reason = $reason;

        // Auto-refund only genuine Stripe payments; pay-in-car / bank transfer
        // are flagged for the admin to handle off-system.
        if ($booking->isPaid() && $booking->isOnlinePayment()) {
            if ($booking->canAutoRefund()) {
                try {
                    $stripeSecretKey = env('STRIPE_SECRET');
                    $stripe = new \Stripe\StripeClient($stripeSecretKey);

                    $refund = $stripe->refunds->create([
                        'payment_intent' => $booking->refund_transaction_reference
                    ]);

                    $booking->refund_status = 'Refunded';
                    $booking->refund_amount = $booking->price;
                    $booking->refund_transaction_reference = $refund->id;
                    $booking->payment_status = 'refunded';
                    $booking->logTimeline('Stripe Refund Processed', 'Auto-processed full refund of £' . number_format($booking->price, 2) . '. Stripe Refund ID: ' . $refund->id, 'System');
                } catch (\Exception $e) {
                    $booking->refund_status = 'Refund Failed';
                    $booking->logTimeline('Refund Processing Failed', 'Stripe refund failed: ' . $e->getMessage(), 'System');
                }
            } else {
                $booking->refund_status = 'Manual Refund Required';
                $booking->logTimeline('Manual Refund Flagged', 'No usable Stripe Payment Intent reference on this booking. Admin needs to process the refund manually.', 'System');
            }
        } elseif ($booking->isPaid()) {
            $booking->refund_status = 'Manual Refund Required';
            $booking->logTimeline('Manual Refund Flagged', 'Payment was taken as "' . $booking->payment_method_label . '". Admin to refund the customer directly.', 'System');
        }

        $booking->save();

        $booking->logTimeline('Booking Rejected', 'Booking request was rejected. Reason: ' . $reason, auth()->user()->name);

        try {
            Mail::to($booking->email)->send(new BookingMail($booking));
        } catch (\Exception $e) {
            // Log or ignore
        }

        return redirect()->back()->with('success', 'Booking Rejected and Customer Notified.');
    }

    public function recordCashReceived(Request $request, $id)
    {
        $booking = Book::findOrFail($id);
        $actor = auth()->user()->name ?? 'Administrator';

        $booking->cash_received = true;
        $booking->cash_received_recorded_at = now();
        $booking->payment_status = 'paid';
        $booking->amount_paid = $booking->price;
        $booking->outstanding_amount = 0;
        $booking->payment_date = now();
        $booking->payment_confirmed_by = $actor;
        $booking->payment_actual_method = $booking->payment_method ?: 'pay_in_car_cash';
        $booking->save();

        $booking->logTimeline('Payment Recorded', 'Admin marked payment of £' . number_format((float) $booking->price, 2) . ' as received (' . $booking->payment_method_label . ').', $actor);

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    /**
     * Manual payment management for the admin — record what was actually paid
     * against a pay-in-car / bank-transfer booking. Never touches Stripe.
     */
    public function updatePayment(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_status'        => 'required|string|in:' . implode(',', array_keys(Book::PAYMENT_STATUSES)),
            'amount_paid'           => 'nullable|numeric|min:0',
            'payment_actual_method' => 'nullable|string|in:' . implode(',', array_keys(Book::PAYMENT_METHODS)),
            'payment_date'          => 'nullable|date',
            'payment_notes'         => 'nullable|string|max:1000',
        ]);

        $booking = Book::findOrFail($id);
        $actor = auth()->user()->name ?? 'Administrator';

        $before = [
            'Payment status' => $booking->payment_status_label,
            'Amount paid'    => '£' . number_format((float) $booking->amount_paid, 2),
        ];

        $newStatus     = $validated['payment_status'];
        $inAmountPaid  = $validated['amount_paid'] ?? null;
        $inActualMeth  = $validated['payment_actual_method'] ?? null;
        $inPaymentDate = $validated['payment_date'] ?? null;
        $inNotes       = $validated['payment_notes'] ?? null;

        $amountPaid = $inAmountPaid !== null ? (float) $inAmountPaid : (float) $booking->amount_paid;

        $booking->payment_status = $newStatus;
        $booking->amount_paid = $amountPaid;
        $booking->outstanding_amount = max((float) $booking->price - $amountPaid, 0);
        $booking->payment_actual_method = $inActualMeth ?: $booking->payment_actual_method;
        $booking->payment_notes = $inNotes ?? $booking->payment_notes;

        if ($newStatus === 'paid') {
            $booking->payment_date = $inPaymentDate ?? ($booking->payment_date ?? now());
            $booking->payment_confirmed_by = $actor;
            if (!$booking->payment_actual_method) {
                $booking->payment_actual_method = $booking->payment_method;
            }
            if ($booking->isPayInCar()) {
                $booking->cash_received = true;
                $booking->cash_received_recorded_at = $booking->payment_date;
            }
        } elseif ($inPaymentDate) {
            $booking->payment_date = $inPaymentDate;
        }

        $booking->save();

        $booking->logChanges([
            'Payment status' => ['from' => $before['Payment status'], 'to' => $booking->payment_status_label],
            'Amount paid'    => ['from' => $before['Amount paid'], 'to' => '£' . number_format((float) $booking->amount_paid, 2)],
        ], $actor, 'Payment updated');

        $extra = [];
        if ($booking->payment_actual_method) {
            $extra[] = 'method used: ' . $booking->payment_actual_method_label;
        }
        if ($booking->payment_date) {
            $extra[] = 'on ' . Carbon::parse($booking->payment_date)->format('d M Y H:i');
        }
        $booking->logTimeline(
            'Payment ' . $booking->payment_status_label,
            'Recorded by ' . $actor . ($extra ? ' (' . implode(', ', $extra) . ')' : '')
            . '. Outstanding: £' . number_format($booking->outstandingBalance(), 2)
            . ($booking->payment_notes ? '. Note: ' . $booking->payment_notes : ''),
            $actor
        );

        return redirect()->back()->with('success', 'Payment details updated.');
    }

    public function cancelBooking(Request $request, $id)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:1000'
        ]);

        $booking = Book::findOrFail($id);
        $reason = $request->input('cancellation_reason');

        $booking->status = 'CANCELLED';
        $booking->cancelled_at = now();
        $booking->cancelled_by = 'Administrator: ' . auth()->user()->name;
        $booking->cancellation_reason = $reason;

        $refundAmount = $this->calculateRefundAmount($booking);
        if ($refundAmount > 0 && $booking->canAutoRefund()) {
            try {
                $stripeSecretKey = env('STRIPE_SECRET');
                $stripe = new \Stripe\StripeClient($stripeSecretKey);

                $refund = $stripe->refunds->create([
                    'payment_intent' => $booking->refund_transaction_reference,
                    'amount' => (int) round($refundAmount * 100)
                ]);

                $booking->refund_status = 'Refunded';
                $booking->refund_amount = $refundAmount;
                $booking->payment_status = 'refunded';
                $booking->logTimeline('Refund Processed', 'Refunded £' . number_format($refundAmount, 2) . ' via Stripe. Refund ID: ' . $refund->id, 'System');
            } catch (\Exception $e) {
                $booking->refund_status = 'Refund Failed';
                $booking->logTimeline('Refund Processing Failed', 'Failed refund of £' . number_format($refundAmount, 2) . ': ' . $e->getMessage(), 'System');
            }
        } elseif ($refundAmount > 0) {
            $booking->refund_status = 'Manual Refund Required';
            $booking->refund_amount = $refundAmount;
            $booking->logTimeline('Manual Refund Flagged', 'Refund of £' . number_format($refundAmount, 2) . ' due (paid via "' . $booking->payment_method_label . '"). Admin to process directly.', 'System');
        }

        $booking->save();

        $booking->logTimeline('Booking Cancelled', 'Booking cancelled by administrator. Reason: ' . $reason, auth()->user()->name);

        try {
            Mail::to($booking->email)->send(new BookingMail($booking));
        } catch (\Exception $e) {
            // Log or ignore
        }

        return redirect()->back()->with('success', 'Booking Cancelled successfully.');
    }

    private function calculateRefundAmount($booking)
    {
        if (!$booking->isOnlinePayment() || !$booking->isPaid()) {
            return 0;
        }

        $pickupDateTime = Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time);
        $hoursUntilPickup = now()->diffInHours($pickupDateTime, false);

        if ($hoursUntilPickup <= 0) {
            return 0;
        }

        $rulesJson = Setting::get('cancellation_refund_rules', '[]');
        $rules = json_decode($rulesJson, true) ?? [
            ['hours' => 24, 'refund_percent' => 100],
            ['hours' => 12, 'refund_percent' => 50],
            ['hours' => 0, 'refund_percent' => 0]
        ];

        usort($rules, function($a, $b) {
            return $b['hours'] <=> $a['hours'];
        });

        $refundPercent = 0;
        foreach ($rules as $rule) {
            if ($hoursUntilPickup >= $rule['hours']) {
                $refundPercent = $rule['refund_percent'];
                break;
            }
        }

        return round(($booking->price * ($refundPercent / 100)), 2);
    }
}
