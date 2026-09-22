<?php

namespace App\Http\Controllers\driver;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriverAceptedBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['data'] = Book::join('users','books.user_id','=','users.id')
            ->whereIn('books.status', ['CONFIRMED', 'DRIVER ASSIGNED', 'IN PROGRESS', 'COMPLETED'])
            ->where(['books.driver_id' => auth()->user()->id])
            ->select('books.*', 'users.name as username','users.phone as userphone','users.address as useraddress')
            ->orderBy('books.id','DESC')
            ->get();
        return view('driver.acceptedbook.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('driver.acceptedbook.create');
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
        return view('driver.acceptedbook.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['data'] = Book::findOrFail($id);
        return view('driver.acceptedbook.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        
        unset($data['_token']);
        unset($data['_method']);

        Book::findOrFail($id)->update($data);
        return redirect()->back()->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
