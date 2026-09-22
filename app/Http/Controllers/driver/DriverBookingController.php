<?php

namespace App\Http\Controllers\driver;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriverBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['data'] = Book::join('users','books.user_id','=','users.id')->whereIn('books.status', ['CONFIRMED', 'DRIVER ASSIGNED'])->where(['books.driver_id' => Null])->select('books.*', 'users.name as username','users.phone as userphone','users.address as useraddress')->get();
        return view('driver.book.index')->with($data);
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
        return view('driver.book.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['data'] = Book::findOrFail($id);
        return view('driver.book.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $data['driver_id'] = auth()->user()->id;
        unset($data['_token']);
        Book::find($id)->update($data);
        return redirect('/driver-booking')->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
