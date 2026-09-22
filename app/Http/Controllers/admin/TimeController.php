<?php

namespace App\Http\Controllers\admin;

use App\Models\Time;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($admweek)
    {
        $data['data'] = Time::where(['week_id' => $admweek])->get();
        $data['admweek'] = $admweek;
        return view('admin.time.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($admweek)
    {
        $data['admweek'] = $admweek;
        return view('admin.time.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$admweek)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        // 
        $data['week_id'] = $admweek;
        unset($data['_token']);
        dd($data);
        Time::create($data);
        return redirect('/admweek')->with('success', 'File Uploaded Successfully');
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
    public function edit($admweek,$time)
    {
        $data['data'] = Time::where(['week_id' => $admweek,'id' => $time])->first();
        $data['admweek'] = $admweek;
        return view('admin.time.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $admweek,$time)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        unset($data['_token']);
        unset($data['_method']);
        Time::where(['week_id' => $admweek,'id' => $time])->update($data);
        return redirect('/admweek')->with('success', 'File Uploaded Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($admweek,$time)
    {
        Time::find($time)->delete();
        return redirect('/admweek')->with('success', 'File Deleted Successfully');
    }
}
