<?php

namespace App\Http\Controllers\admin;

use App\Models\Distances;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data['data'] = Distances::where(['car_id' => $id])->get();
        $data['car_id'] = $id;
        return view('admin.distance.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['car_id'] = $id;
        return view('admin.distance.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $data = $request->all();
        $data['car_id'] = $id;
        // $data['password'] = Hash::make($data['password']);
        unset($data['_token']);
        Distances::create($data);
        return redirect()->route('admcar.admdistance.index',$id)->with('success', 'File Uploaded Successfully');
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
    public function edit($car_id,$id)
    {
        $data['car_id'] = $car_id;
        $data['data'] = Distances::find($id);
        return view('admin.distance.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $distance)
    {
        
        $data = $request->all();
        // dd($distance);
        unset($data['_token']);
        Distances::find($id)->update($data);
        return redirect()->route('admcar.admdistance.index',$distance)->with('success', 'File Uploaded Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($distance,$id)
    {
        Distances::find($id)->delete();
        return redirect()->route('admcar.admdistance.index',$distance)->with('success', 'File Deleted Successfully');
    }
}
