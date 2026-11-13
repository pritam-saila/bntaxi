<?php

namespace App\Http\Controllers;

use Stripe;
use App\Models\Book;
use App\Mail\BookingMail;
use App\Services\CardPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $booking_id = $request->input('booking_id');
        
        Session::put('stripedata', $booking_id);

        // pk_live_51LPUhCAI1UCqtVCeMQihD5BXdUbgVYYr6w5t1kbcL3ehCM6hgwkWDMvQcasH6sXz9zCQTfqQpzUB5nRgyiRajj5n00kR86OP1B
        
        header('Content-Type: application/json');
        $stripeSecretKey = env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        $product = $stripe->products->create(['name' => $name]);
        $strstipe = $stripe->prices->create([
        'product' => $product->id,
        'unit_amount' => (int) round(floatval($price) * 100),
        'currency' => 'GBP',
        ]);
        // dd($strstipe);

        $checkout_session = $stripe->checkout->sessions->create([
        'line_items' => [[
            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price' => $strstipe->id,
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => url('success?session_id={CHECKOUT_SESSION_ID}'),
        'cancel_url' => url('cancel'),
        ]);
        return redirect()->away($checkout_session->url);
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $payments = app(CardPaymentService::class);
        $sessionId = $request->get('session_id');

        // Prefer the booking the Stripe session was opened for; fall back to the
        // browser session for payments started before that link was recorded.
        $booking = $sessionId ? Book::where('stripe_session_id', $sessionId)->first() : null;
        if (!$booking && ($id = Session::get('stripedata'))) {
            $booking = Book::findOrFail($id);
        }

        if ($booking) {
            $paymentIntentId = null;

            if ($sessionId) {
                try {
                    $session = $payments->retrieveSession($sessionId);
                    $paymentIntentId = $session->payment_intent;

                    if ($session->payment_status !== 'paid') {
                        return redirect()->route('booking.confirmation', $booking->access_token)
                            ->with('error', 'Your payment has not been completed, so this booking is not yet paid for.');
                    }
                } catch (\Exception $e) {
                    // Ignore or log
                }
            }

            // Reloading the success page must not record the payment (or email) twice.
            if (!$booking->isPaid()) {
                $payments->markPaid($booking, $paymentIntentId);
            }

            return redirect()->route('booking.confirmation', $booking->access_token)
                ->with('success', 'Your payment was received. Your booking request is now pending approval.');
        }

        return redirect('/')->with('error', 'We could not locate your booking session. Please contact us if you were charged.');
    }

    public function show($id){
        $data = Book::join('categories', 'categories.id', '=', 'books.service')
        ->join('providers', 'providers.id', '=', 'books.provider')
        ->where(['books.status' => 'Active'])->orderBy('books.id', 'DESC')
        ->first(['books.*','categories.title as servicetitle','providers.title as providerstitle']);
        
        Mail::to('sailapritam@gmail.com')->send(new BookingMail($data));

        return "Email has been sent.";
    }
}