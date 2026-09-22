<?php

namespace App\Http\Controllers\artist;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Categorypricing;
use App\Http\Controllers\Controller;

class ArtSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($admcategory)
    {
        $data['data'] = Category::where(['cat_id' => $admcategory])->get();

        foreach ($data['data'] as $value) {
            $price = Categorypricing::where(['cat_id' => $value->id,'subcat_id' => $value->cat_id,'user_id' => auth()->user()->id])->first();
            if ($price) {
                $value->price = $price->price;
            } else {
                $value->price = 0;
            }
            
        }

        $data['cat_id'] = $admcategory;
        return view('artist.subcategory.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($admcategory)
    {
        $data['cat_id'] = $admcategory;
        return view('artist.subcategory.create')->with($data);
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
        $data['user_id'] = auth()->user()->id;
        // if ($request->hasFile('image')) {
        //     // $data['image'] = $request->image->storeAs('/public/images', time() . "." . $request->image->extension());
        //     $data['image'] = time().'.'.$request->image->getClientOriginalExtension();
        //     $destinationPath = public_path('/images');
        //     $request->image->move($destinationPath, $data['image']);
        // }
        // $data['password'] = Hash::make($data['password']);
        unset($data['_token']);
        Categorypricing::create($data);
        return redirect()->route('artcategory.artsubcategory.index',$data['subcat_id'])->with('success', 'Price added Successfully');
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
        return view('artist.subcategory.edit')->with($data);
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
            // $data['image'] = $request->image->storeAs('/public/images', time() . "." . $request->image->extension());
            $data['image'] = time().'.'.$request->image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $request->image->move($destinationPath, $data['image']);
        }
        unset($data['_token']);
        Category::find($id)->update($data);
        return redirect()->route('artcategory.artsubcategory.index',$admcategory)->with('success', 'File Uploaded Successfully');
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
        return redirect()->route('artcategory.artsubcategory.index',$admcategory)->with('success', 'File Deleted Successfully');
    }
}
