<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all users with type 0 (customer/user)
        $data['data'] = User::where('type', 0)->get();
        return view('admin.customer.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['type'] = 0; // Set user type to 'user'
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        unset($data['_token']);
        User::create($data);
        return redirect()->route('admcustomer.index')->with('success', 'Customer Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['data'] = User::findOrFail($id);
        return view('admin.customer.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        unset($data['_token']);
        User::findOrFail($id)->update($data);
        return redirect()->route('admcustomer.index')->with('success', 'Customer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admcustomer.index')->with('success', 'Customer Deleted Successfully');
    }
}
