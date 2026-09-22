<?php

namespace App\Http\Controllers\driver;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe;
use App\Models\Book;
use App\Mail\BookingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class DriverDashboardController extends Controller
{
    public function useraccount(){
        $driver = User::find(auth()->user()->id);

        return view('driver.myprofile', [
            'data'    => $driver,
            'overall' => app(\App\Services\DriverVerificationService::class)->overall($driver),
        ]);
    }

    /**
     * Only these fields can be changed from the profile form. Anything else in the
     * request (type, status, password, ...) is ignored - a driver must not be able
     * to promote or activate themselves by posting extra fields.
     */
    public function userupdate(Request $request){
        $driver = User::find(auth()->user()->id);

        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users', 'email')->ignore($driver->id)],
            'phone'            => ['required', 'string', 'regex:/^\+?[0-9()\s-]{7,20}$/'],
            'company_name'     => 'nullable|string|max:255',
            'address'          => 'required|string|max:500',
            'vatnumber'        => 'nullable|string|max:50',
            'companyregnumber' => 'nullable|string|max:50',
            'vehicleregnumber' => 'required|string|max:20',
            'make'             => 'required|string|max:100',
            'model'            => 'required|string|max:100',
        ], [
            'phone.regex'  => 'Enter a valid contact number (digits, spaces, + ( ) - only).',
            'email.unique' => 'That email address is already used by another account.',
        ]);

        $driver->update($data);

        return redirect()->route('driveraccount')->with('success', 'Your details have been updated.');
    }

    public function updatepassword(Request $request){
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ], [
            'current_password.current_password' => 'That isn\'t your current password.',
            'password.confirmed'                => 'The new password and its confirmation don\'t match.',
        ]);

        User::find(auth()->user()->id)->update(['password' => $data['password']]);   // hashed by the model cast

        return redirect()->route('driverchangepass')->with('success', 'Your password has been changed.');
    }

    public function placeorder(){
        $data = request()->all();
        $packagearr = json_decode($data['pacagedetails']);
        $val = [
        'user_id' => auth()->user()->id,
        'booking_id' => 'Goos2u'.time(),
        'name'	=> $data['name'],
        'email'	=> $data['email'],
        'phone'	=> $data['phone'],
        'price'	=> $packagearr->pricing,
        'date'	=> $packagearr->date,
        'time'	=> $packagearr->time,
        'bookedarr'	=> serialize($packagearr),
        'created_at' => date('Y-m-d H:i:s')
        ];

        $price = $packagearr->pricing;
        $bookid = Book::insertGetId($val);
        Session::put('stripedata', $bookid);

        header('Content-Type: application/json');
        $stripeSecretKey = env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        $product = $stripe->products->create(['name' => 'pricing value']);
        $strstipe = $stripe->prices->create([
        'product' => $product->id,
        'unit_amount' => floatval($price) * 100,
        'currency' => 'GBP',
        ]);
        // dd($strstipe);

        \Stripe\Stripe::setApiKey($stripeSecretKey);
        

        $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [[
            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price' => $strstipe->id,
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => url('success'),
        'cancel_url' => url('cancel'),
        ]);
        return redirect()->away($checkout_session->url);
        // dd($val);
    }

    public function order(){
        $data['booking'] = Book::join('users','books.user_id','=','users.id')->where(['books.user_id' => auth()->user()->id])->select('books.*', 'users.name as username','users.phone as userphone','users.address as useraddress',)->get();
        // dd($data);
        return view('web.booking')->with($data);
    }

    public function calendar(){
        return view('web.calender');
    }
}
