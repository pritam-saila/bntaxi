<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use App\Models\Banner;
use App\Models\User;
use App\Models\Book;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\Content;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Routehandle;
use Illuminate\Support\Str;
use App\Services\PricingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMail;
use App\Mail\CustomerBookingConfirmationMail;
use App\Mail\AdminBookingNotificationMail;
use Barryvdh\DomPDF\Facade\Pdf;

class WebController extends Controller
{
    protected $pricingService;
    protected $bookingPricing;
    protected $routeService;

    public function __construct(
        PricingService $pricingService,
        \App\Services\BookingPricingService $bookingPricing,
        \App\Services\RouteService $routeService
    ) {
        $this->pricingService = $pricingService;
        $this->bookingPricing = $bookingPricing;
        $this->routeService = $routeService;
    }

    public function index(){
        $data['distnceprice'] = Cars::all();
        $data['banner'] = Banner::all();
        $data['testimonials'] = Testimonial::all();
        $data['about'] = Content::find(1);
        $data['date'] = date('Y-m-d');
        $data['time'] = date('H:i');
        // dd($data);
        return view('goods.index')->with($data);
    }

    public function about(){
        $data['about'] = Content::find(1);
        return view('goods.about')->with($data);
    }
    public function booking(){
        
        return view('goods.booking');
    }

    

    public function news(){
         $data['blogs'] = Blog::orderBy('date', 'desc')->get();
         return view('goods.news')->with($data);
    }
    
    public function newsdetails($id){
         $data['blog'] = Blog::where('slug', $id)->firstOrFail();
         $data['recent_blogs'] = Blog::where('id', '!=', $id)->orderBy('date', 'desc')->take(5)->get();
         return view('goods.news-details')->with($data);
    }
    
    public function gallery(){
         $data['galleries'] = Gallery::all();
         return view('goods.gallery')->with($data);
    }
    
    public function faq(){
         return view('goods.faq');
    }
    
    public function userlogin(){
         return view('goods.user-login');
    }
    
    public function userregister(){
         return view('goods.user-register');
    }

    public function postuserregister(Request $request){
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            // Scoped to type=0 (customer): the same email may already belong to a
            // driver account - that's a different role, not a clash.
            'email'   => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users', 'email')->where('type', 0)],
            'password' => 'required|string|min:6|max:100',
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'email.unique' => 'An account with this email already exists. Try logging in instead.',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'],
            'address'  => $data['address'] ?? null,
            'type'     => 0, // Type 0 is for Normal User
            'status'   => 1, // 1 for Active User
        ]);

        return redirect('/user-login')->with('success', 'Your registration is successful. Please login.');
    }

      public function myprofile(){
         if (!auth()->check()) {
             return redirect('/user-login');
         }
         return view('goods.my-profile');
    }
    
    public function booknow(){
         return view('goods.book-now');
    }
    
    public function mypayment(Request $request){
         $booking_id = $request->get('booking_id');
         $data['booking'] = Book::find($booking_id);
         return view('goods.my-payment')->with($data);
    }
    
    public function mybooking(Request $request){
         if (!auth()->check()) {
             return redirect('/user-login');
         }

         $search = trim((string) $request->query('q', ''));

         $query = Book::where('user_id', auth()->user()->id);

         if ($search !== '') {
             $query->where(function ($q) use ($search) {
                 $like = '%' . $search . '%';
                 $q->where('booking_id', 'like', $like)
                   ->orWhere('pickup', 'like', $like)
                   ->orWhere('dropoff', 'like', $like)
                   ->orWhere('status', 'like', $like)
                   ->orWhere('pickup_date', 'like', $like);
             });
         }

         $data['bookings'] = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
         $data['search'] = $search;

         return view('goods.my-booking')->with($data);
    }
    public function useraccount(){
         $user = auth()->user();
         $totalBookings = $user ? Book::where('user_id', $user->id)->count() : 0;
         $totalSpent = $user ? Book::where('user_id', $user->id)->whereIn('payment_status', ['paid', 'partially_paid'])->sum('amount_paid') : 0;
         $upcomingRide = $user ? Book::where('user_id', $user->id)
             ->where(function($q) {
                 $q->whereDate('pickup_date', '>=', Carbon::today())
                   ->orWhereDate('created_at', '>=', Carbon::today());
             })
             ->orderBy('pickup_date', 'asc')
             ->orderBy('created_at', 'asc')
             ->first() : null;

         return view('goods.user-account', compact('totalBookings', 'totalSpent', 'upcomingRide'));
    }
    
     public function driverlogin(){
         return view('goods.driver-login');
    }

    public function driverregister(){
        $data['distnceprice'] = Cars::all();
        return view('goods.driver-register')->with($data);
    }

    /**
     * Step 1 of driver registration: create the account as a *pending application*
     * (inactive, so no bookings yet) and sign the applicant in. Step 2 is the
     * documentation page, where they upload their documents for admin verification.
     */
    public function postdriverregister(Request $request){
        $data = $request->validate([
            'first_name'       => 'required|string|max:120',
            'last_name'        => 'required|string|max:120',
            // Scoped to type=2 (driver): the same email may already belong to a
            // customer account - that's a different role, not a clash.
            'email'            => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users', 'email')->where('type', 2)],
            'password'         => 'required|string|min:8|max:100',
            'phone'            => ['required', 'string', 'regex:/^\+?[0-9()\s-]{7,20}$/'],
            'address'          => 'required|string|max:500',
            'postcode'         => ['required', 'string', 'max:12', 'regex:/^[A-Za-z]{1,2}\d[A-Za-z\d]?\s*\d[A-Za-z]{2}$/'],
            'vehicleregnumber' => 'required|string|max:20',
            'make'             => 'required|string|max:100',
            'model'            => 'required|string|max:100',
            'cartype'          => 'required|exists:cars,id',
            'checkbox'         => 'accepted',
        ], [
            'phone.regex'      => 'Enter a valid phone number (digits, spaces, + ( ) - only).',
            'postcode.regex'   => 'Enter a valid UK post code.',
            'email.unique'     => 'A driver account with this email already exists. Try logging in instead.',
            'checkbox.accepted' => 'Please agree to the terms & policy to continue.',
        ]);

        $driver = \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
            $driver = User::create([
                'name'             => trim($data['first_name'] . ' ' . $data['last_name']),
                'first_name'       => $data['first_name'],
                'last_name'        => $data['last_name'],
                'email'            => $data['email'],
                'password'         => $data['password'],      // hashed by the model cast
                'phone'            => $data['phone'],
                'address'          => $data['address'],
                'postcode'         => $data['postcode'],
                'vehicleregnumber' => $data['vehicleregnumber'],
                'make'             => $data['make'],
                'model'            => $data['model'],
                'cartype'          => $data['cartype'],
                'type'             => 2,   // driver
                'status'           => 0,   // inactive until an admin verifies the documents and approves
            ]);

            \App\Models\DriverProfile::create([
                'user_id'            => $driver->id,
                'application_status' => \App\Models\DriverProfile::APPLICATION_PENDING,
            ]);

            return $driver;
        });

        // Signed in, but the account is inactive: the "active-driver" gate keeps them
        // inside the documentation area until an admin approves the application.
        \Illuminate\Support\Facades\Auth::login($driver);
        $request->session()->regenerate();

        return redirect()->route('driver.docs.index')->with(
            'dd_success',
            'Your account has been created. Step 2 of 2: complete your details and upload your documents below — an administrator will verify them and activate your account.'
        );
    }

   

    public function contact(){
        return view('goods.contact');
    }

    public function postcontact(Request $request){
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'message' => 'required|string|max:5000',
        ]);

        // Honeypot: bots fill hidden fields. Pretend success, send nothing.
        if ($request->filled('website')) {
            return redirect()->back()->with('success', 'Thanks for getting in touch — we will reply shortly.');
        }

        $validated['submitted_at'] = now()->format('d M Y H:i');
        $validated['ip'] = $request->ip();

        try {
            Mail::to(Book::adminNotificationRecipients())
                ->send(new \App\Mail\ContactMail($validated));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Contact form email failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with(
                'error',
                'Sorry, we could not send your message right now. Please call us on 01273 757373.'
            );
        }

        return redirect()->back()->with(
            'success',
            'Thanks for getting in touch — we have received your message and will reply shortly.'
        );
    }

    public function review(Request $request){
        $data = $request->all();
        if(isset($data['car'])){
            $data['cardata'] = Cars::find($data['car']);
        }
        return view('goods.review')->with($data);
    }

    public function orderreview(Request $request){
        $data = $request->all();
        if (isset($data['car_id'])) {
            $data['cardata'] = Cars::find($data['car_id']);
        }
        return view('goods.order-review')->with($data);
    }

    public function postorderreview(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'car_id' => 'required',
            'pickup' => 'required',
            'dropoff' => 'required',
            'passengers' => 'required|integer|min:1',
            'bags' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        $pickup = $data['pickup'] ?? '';
        $dropoff = $data['dropoff'] ?? '';

        // Prepayment constraints: Outside dynamic Local Area (e.g. Brighton & Hove) -> Inside Local Area
        // OR to/from any dynamic prepaid destinations (e.g. Airports/Stations)
        $localAreas = \App\Models\Setting::getArray('local_operating_areas', ['brighton', 'hove']);
        $prepayDestinations = \App\Models\Setting::getArray('prepayment_required_destinations', [
            'gatwick', 'heathrow', 'luton', 'stansted', 'city airport', 'london city', 'st pancras', 'st. pancras', 'pancras'
        ]);

        $isOutsideLocal = true;
        foreach ($localAreas as $area) {
            if (stripos($pickup, $area) !== false) {
                $isOutsideLocal = false;
                break;
            }
        }
        
        $isFixedPrice = false;
        foreach ($prepayDestinations as $fd) {
            if (stripos($pickup, $fd) !== false || stripos($dropoff, $fd) !== false) {
                $isFixedPrice = true;
                break;
            }
        }

        $mustPrepay = $isOutsideLocal;
        $payment_method = $data['payment_method'] ?? 'stripe';

        if ($mustPrepay && $payment_method === 'cash') {
            return redirect()->back()->withInput()->with('error', 'Journeys starting from outside our local area (' . implode(', ', $localAreas) . ') must be prepaid online.');
        }

        // --- Minimum journey distance (8 miles), measured across the full route ---
        $routeAddresses = array_values(array_filter(array_map('trim', $data['distancearr'] ?? [])));
        if (count($routeAddresses) < 2) {
            $routeAddresses = array_values(array_filter([$pickup, $dropoff]));
        }
        $journeyMiles = $this->routeService->distanceMiles($routeAddresses);
        if (($data['is_return'] ?? 0) == 1) {
            $journeyMiles *= 2;
        }
        $minCheck = $this->bookingPricing->minimumDistanceCheck($journeyMiles);
        if ($minCheck['blocked']) {
            return redirect('/')->withInput()->with('error', $minCheck['message']);
        }

        $booking = new Book();
        $booking->booking_id = 'BKG-'.time();
        $booking->source = 'web';

        if (auth()->check()) {
            $booking->user_id = auth()->user()->id;
        } else {
            if (isset($data['create_account']) && $data['create_account'] == '1') {
                $user = User::where('email', $data['email'])->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'password' => Hash::make(Str::random(10)),
                        'type' => 0,
                        'status' => 1
                    ]);
                }
                auth()->login($user);
                $booking->user_id = $user->id;
            } else {
                $booking->user_id = null;
            }
        }

        $booking->name = $data['name'];
        $booking->email = $data['email'];
        $booking->phone = $data['phone'];
        $booking->flight_number = $data['flight_number'] ?? null;
        $booking->airline = $data['airline'] ?? null;
        $booking->flight_airport = $data['flight_airport'] ?? null;
        $booking->flight_direction = $data['flight_direction'] ?? null;
        $booking->flight_origin_destination = $data['flight_origin_destination'] ?? null;
        $booking->flight_scheduled_time = $data['flight_scheduled_time'] ?? null;
        $booking->passengers = $data['passengers'] ?? 1;
        $booking->bags = $data['bags'] ?? 0;
        $booking->special_instructions = $data['special_instructions'] ?? null;
        $booking->car_id = $data['car_id'] ?? null;
        $booking->price = $data['price'] ?? 0;
        $booking->distance = $data['distance'] ?? 0;
        $booking->pickup = $pickup;
        $booking->dropoff = $dropoff;

        if ($booking->pickup) {
            $pickupCoords = $this->pricingService->get_lat_long($booking->pickup);
            $booking->from_lat = $pickupCoords[0] ?? null;
            $booking->from_lng = $pickupCoords[1] ?? null;
        }

        if ($booking->dropoff) {
            $dropoffCoords = $this->pricingService->get_lat_long($booking->dropoff);
            $booking->to_lat = $dropoffCoords[0] ?? null;
            $booking->to_lng = $dropoffCoords[1] ?? null;
        }
        $booking->distancearr = isset($data['distancearr']) ? $data['distancearr'] : null;
        $booking->vias = isset($data['distancearr']) ? $data['distancearr'] : null;
        $booking->pickup_date = $data['pickup_date'] ?? null;
        $booking->pickup_time = $data['pickup_time'] ?? null;
        $booking->return_date = $data['return_date'] ?? null;
        $booking->return_time = $data['return_time'] ?? null;
        $booking->is_return = $data['is_return'] ?? 0;
        $booking->payment_method = $payment_method === 'cash' ? 'pay_in_car_cash' : 'stripe';
        $booking->status = 'PENDING APPROVAL';
        // Online bookings are "awaiting" until Stripe confirms; cash bookings are simply unpaid.
        $booking->payment_status = $payment_method === 'cash' ? 'unpaid' : 'pending_payment';
        $booking->amount_paid = 0;
        $booking->outstanding_amount = $booking->price;
        $booking->save();

        // Log to timeline
        $booking->logTimeline('Booking Request Received', 'Booking request submitted by ' . $booking->name . ' via the online form. Status set to PENDING APPROVAL.', 'Customer');

        if ($payment_method === 'cash') {
            $this->sendBookingPlacedEmails($booking);

            return redirect()->route('booking.confirmation', $booking->access_token)
                ->with('success', 'Your booking request has been submitted and is pending approval. You can pay in the car once confirmed.');
        }

        session()->put('stripedata', $booking->id);

        $stripeSecretKey = env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        $product = $stripe->products->create(['name' => 'Booking ' . $booking->booking_id]);
        $strstipe = $stripe->prices->create([
            'product' => $product->id,
            'unit_amount' => (int) round(floatval($booking->price) * 100),
            'currency' => 'GBP',
        ]);

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price' => $strstipe->id,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('user-account'),
        ]);

        return redirect()->away($checkout_session->url);
    }
    
    public function serviceDetails($slug){
         $data['service'] = Service::where('slug', $slug)->firstOrFail();
         return view('goods.service-details')->with($data);
    }

    public function routeDetails($slug){
         $data['route'] = Routehandle::where('slug', $slug)->firstOrFail();
         $data['faqs'] = Faq::where('routehandle_id', $data['route']->id)->get();
         return view('goods.route-details')->with($data);
    }

    /* =================================================================
     |  Public booking pages (emailed links - no login required)
     * ================================================================= */

    public function bookingConfirmation($token)
    {
        $booking = Book::where('access_token', $token)->firstOrFail();
        return view('goods.booking-confirmation', compact('booking'));
    }

    public function bookingReceipt($token)
    {
        $booking = Book::where('access_token', $token)->firstOrFail();
        return Pdf::loadView('pdf.booking-receipt', compact('booking'))
            ->stream('receipt-' . $booking->booking_id . '.pdf');
    }

    public function cancelBookingShow($token)
    {
        $booking = Book::where('access_token', $token)->firstOrFail();
        return view('goods.booking-cancel-confirm', compact('booking'));
    }

    public function cancelBookingByToken(Request $request, $token)
    {
        $request->validate(['cancellation_reason' => 'nullable|string|max:1000']);

        $booking = Book::where('access_token', $token)->firstOrFail();

        if (!$booking->isCancellable()) {
            return redirect()->route('booking.cancel.show', $token)
                ->with('error', 'This booking can no longer be cancelled.');
        }

        $this->applyCancellation(
            $booking,
            'Customer (email link)',
            $request->input('cancellation_reason') ?: 'Cancelled by customer via the emailed cancellation link.'
        );

        return redirect()->route('booking.confirmation', $token)
            ->with('success', 'Your booking has been cancelled. A confirmation has been emailed to you.');
    }

    /**
     * Authenticated cancel from the customer's "My bookings" dashboard.
     */
    public function cancelBooking(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/user-login');
        }

        $booking = Book::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();

        if (!$booking->isCancellable()) {
            return redirect()->back()->with('error', 'This booking cannot be cancelled.');
        }

        $this->applyCancellation(
            $booking,
            'Customer: ' . auth()->user()->name,
            'Cancelled by customer via online portal.'
        );

        return redirect()->back()->with('success', 'Your booking has been cancelled successfully.');
    }

    /* =================================================================
     |  Shared helpers
     * ================================================================= */

    /**
     * Apply a customer-initiated cancellation: set status, run the refund
     * rules (auto Stripe refund where possible, otherwise flag for manual),
     * log the timeline and notify the customer + admin.
     */
    protected function applyCancellation(Book $booking, string $by, ?string $reason): void
    {
        $booking->status = 'CANCELLED';
        $booking->cancelled_at = now();
        $booking->cancelled_by = $by;
        $booking->cancellation_reason = $reason;

        $refundAmount = 0;
        if ($booking->isOnlinePayment() && $booking->isPaid()) {
            $pickupDateTime = \Carbon\Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time);
            $hoursUntilPickup = now()->diffInHours($pickupDateTime, false);

            if ($hoursUntilPickup > 0) {
                $rulesJson = \App\Models\Setting::get('cancellation_refund_rules', '[]');
                $rules = json_decode($rulesJson, true) ?: [
                    ['hours' => 24, 'refund_percent' => 100],
                    ['hours' => 12, 'refund_percent' => 50],
                    ['hours' => 0, 'refund_percent' => 0]
                ];

                usort($rules, fn ($a, $b) => $b['hours'] <=> $a['hours']);

                $refundPercent = 0;
                foreach ($rules as $rule) {
                    if ($hoursUntilPickup >= $rule['hours']) {
                        $refundPercent = $rule['refund_percent'];
                        break;
                    }
                }

                $refundAmount = round(($booking->price * ($refundPercent / 100)), 2);
            }

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
                $booking->logTimeline('Manual Refund Flagged', 'Refund of £' . number_format($refundAmount, 2) . ' due. Admin to process directly.', 'System');
            }
        }

        $booking->save();
        $booking->logTimeline('Booking Cancelled', 'Booking cancelled. Reason: ' . $reason, $by);

        try {
            Mail::to($booking->email)->send(new BookingMail($booking));
            Mail::to(Book::adminNotificationRecipients())->send(new BookingMail($booking));
        } catch (\Exception $e) {
            // Log or ignore
        }
    }

    /**
     * Fire the customer confirmation (with PDF receipt) and the admin
     * dispatch notification once a booking has been placed / paid.
     */
    protected function sendBookingPlacedEmails(Book $booking): void
    {
        try {
            Mail::to($booking->email)->send(new CustomerBookingConfirmationMail($booking));
            Mail::to(Book::adminNotificationRecipients())->send(new AdminBookingNotificationMail($booking));
            $booking->logTimeline('Confirmation Emails Sent', 'Customer confirmation (with receipt) and admin notification sent.', 'System');
        } catch (\Exception $e) {
            $booking->logTimeline('Confirmation Email Failed', 'Could not send booking emails: ' . $e->getMessage(), 'System');
        }
    }

}
