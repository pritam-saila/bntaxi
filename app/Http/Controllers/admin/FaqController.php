<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Routehandle;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($routehandle)
    {
        $data['routehandle'] = Routehandle::findOrFail($routehandle);
        $data['data'] = Faq::where('routehandle_id', $routehandle)->get();
        
        return view('admin.routehandles.faq.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($routehandle)
    {
        $data['routehandle'] = Routehandle::findOrFail($routehandle);
        
        return view('admin.routehandles.faq.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $routehandle)
    {
        $data = $request->all();
        $data['routehandle_id'] = $routehandle;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        unset($data['_token']);
        Faq::create($data);
        
        return redirect()->route('admin.routehandles.faq.index', $routehandle)->with('success', 'FAQ Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($routehandle, Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($routehandle, Faq $faq)
    {
        $data['routehandle'] = Routehandle::findOrFail($routehandle);
        $data['data'] = $faq;
        
        return view('admin.routehandles.faq.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $routehandle, Faq $faq)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? $faq->sort_order);
        
        $faq->update($data);
        
        return redirect()->route('admin.routehandles.faq.index', $routehandle)->with('success', 'FAQ Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($routehandle, Faq $faq)
    {
        $faq->delete();
        
        return redirect()->route('admin.routehandles.faq.index', $routehandle)->with('success', 'FAQ Deleted Successfully');
    }
}
