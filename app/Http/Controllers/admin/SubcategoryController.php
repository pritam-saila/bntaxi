<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($admcategory)
    {
        $data['data'] = Category::where(['cat_id' => $admcategory])->get();
        $data['cat_id'] = $admcategory;
        return view('admin.subcategory.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($admcategory)
    {
        $data['cat_id'] = $admcategory;
        return view('admin.subcategory.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$admcategory)
    {
        $data = $request->all();
        $data['cat_id'] = $admcategory;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        // $data['password'] = Hash::make($data['password']);
        unset($data['_token']);
        Category::create($data);
        return redirect()->route('admcategory.subcategory.index',$admcategory)->with('success', 'File Uploaded Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$admcategory)
    {
        $data['data'] = Category::find($id);
        $data['cat_id'] = $admcategory;
        return view('admin.subcategory.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$admcategory)
    {
        $data = $request->all();
        $data['cat_id'] = $admcategory;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        unset($data['_token']);
        Category::find($id)->update($data);
        return redirect()->route('admcategory.subcategory.index',$admcategory)->with('success', 'File Uploaded Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$admcategory)
    {
        Category::find($id)->delete();
        return redirect()->route('admcategory.subcategory.index',$admcategory)->with('success', 'File Deleted Successfully');
    }
}
