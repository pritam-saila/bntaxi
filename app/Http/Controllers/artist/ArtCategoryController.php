<?php

namespace App\Http\Controllers\artist;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['data'] = Category::whereNull('cat_id')->get();
        return view('artist.category.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('artist.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            // $data['image'] = $request->image->storeAs('/public/images', time() . "." . $request->image->extension());
            $data['image'] = time().'.'.$request->image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $request->image->move($destinationPath, $data['image']);
        }
        // $data['password'] = Hash::make($data['password']);
        unset($data['_token']);
        Category::create($data);
        return redirect('/artcategory')->with('success', 'File Uploaded Successfully');
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
    public function edit($id)
    {
        $data['data'] = Category::find($id);
        return view('artist.category.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            // $data['image'] = $request->image->storeAs('/public/images', time() . "." . $request->image->extension());
            $data['image'] = time().'.'.$request->image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $request->image->move($destinationPath, $data['image']);
        }
        unset($data['_token']);
        Category::find($id)->update($data);
        return redirect('/artcategory')->with('success', 'File Uploaded Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect('/artcategory')->with('success', 'File Deleted Successfully');
    }
}
