<?php

namespace App\Http\Controllers;

use Stripe;
use App\Models\Book;
use App\Mail\BookingMail;
use App\Mail\CustomerBookingConfirmationMail;
use App\Mail\AdminBookingNotificationMail;
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
        $id = Session::get('stripedata');
        if ($id) {
            $booking = Book::findOrFail($id);
            $paymentIntentId = null;

            if ($request->has('session_id')) {
                try {
                    $stripeSecretKey = env('STRIPE_SECRET');
                    $stripe = new \Stripe\StripeClient($stripeSecretKey);
                    $session = $stripe->checkout->sessions->retrieve($request->get('session_id'));
                    $paymentIntentId = $session->payment_intent;
                } catch (\Exception $e) {
                    // Ignore or log
                }
            }

            $booking->update([
               'status' => 'PENDING APPROVAL',
               'payment_method' => 'stripe',
               'payment_status' => 'paid',
               'payment_actual_method' => 'stripe',
               'amount_paid' => $booking->price,
               'outstanding_amount' => 0,
               'payment_date' => now(),
               'payment_confirmed_by' => 'Stripe (online)',
               'refund_transaction_reference' => $paymentIntentId
            ]);

            // Log timeline and save
            $booking->logTimeline('Payment Received', 'Online payment of £' . number_format($booking->price, 2) . ' received successfully via Stripe.', 'Stripe');

            try {
                Mail::to($booking->email)->send(new CustomerBookingConfirmationMail($booking));
                Mail::to(Book::adminNotificationRecipients())->send(new AdminBookingNotificationMail($booking));
                $booking->logTimeline('Confirmation Emails Sent', 'Customer confirmation (with receipt) and admin notification sent.', 'System');
            } catch (\Exception $e) {
                $booking->logTimeline('Confirmation Email Failed', 'Could not send booking emails: ' . $e->getMessage(), 'System');
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