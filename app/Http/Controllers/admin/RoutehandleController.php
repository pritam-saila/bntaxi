<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Routehandle;
use Illuminate\Http\Request;

class RoutehandleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['data'] = Routehandle::all();
        return view('admin.routehandles.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.routehandles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        unset($data['_token']);
        Routehandle::create($data);
        return redirect()->route('admin.routehandles.index')->with('success', 'Route Handle Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Routehandle $routehandle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Routehandle $routehandle)
    {
        $data['data'] = $routehandle;
        return view('admin.routehandles.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Routehandle $routehandle)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        unset($data['_token']);
        unset($data['_method']);
        $routehandle->update($data);
        return redirect()->route('admin.routehandles.index')->with('success', 'Route Handle Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Routehandle $routehandle)
    {
        $routehandle->delete();
        return redirect()->route('admin.routehandles.index')->with('success', 'Route Handle Deleted Successfully');
    }
}
