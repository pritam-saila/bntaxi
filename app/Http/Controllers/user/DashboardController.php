<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe;
use App\Models\Book;
use App\Mail\BookingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function useraccount(){
        $data['user'] = User::find(auth()->user()->id);
        return view('goods.account-details')->with($data);
    }

    public function userupdate(Request $request){
        $data = request()->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        User::find(auth()->user()->id)->update($data);
        return redirect()->back()->with('success', 'Data Updated Successfully');
    }

    public function updatepassword(){
        $data = request()->all();
        if ($data['newpass'] != $data['confirmpass']) {
            return redirect('/user-change-password')->with('error', 'confirm password doesn`t match with new password');
        } else {
            $val['password'] = bcrypt($data['confirmpass']);
            User::find(auth()->user()->id)->update($val);
            return redirect('/user-change-password')->with('success', 'Data Updated Successfully');
        }
    }

    public function placeorder(){
        $data = request()->all();
        $data['user_id'] = auth()->user()->id;
        $data['booking_id'] = 'Goos2u'.time();
        $book = Book::create($data);
        Session::put('stripedata', $book->id);

        header('Content-Type: application/json');
        $stripeSecretKey = env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        $product = $stripe->products->create(['name' => 'pricing value']);
        $strstipe = $stripe->prices->create([
        'product' => $product->id,
        'unit_amount' => floatval($data['price']) * 100,
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
        'cancel_url' => url()->previous(),
        ]);
        return redirect()->away($checkout_session->url);
        // dd($val);
    }

    public function order(){
        $data['booking'] = Book::join('users','books.user_id','=','users.id')->where(['books.user_id' => auth()->user()->id])->select('books.*', 'users.name as username','users.phone as userphone','users.address as useraddress')->orderBy('id', 'DESC')->get();
        // dd($data);
        return view('goods.order')->with($data);
    }

    public function calendar(){
        return view('goods.calender');
    }
}
