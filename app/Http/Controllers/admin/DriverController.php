<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Cars;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['data'] = User::where(['type' => 2])->get();
        return view('admin.driver.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['distnceprice'] = Cars::all();
        return view('admin.driver.create')->with($data);
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

        $fileFields = ['image', 'hireandrewardinsurance', 'goodsintransitinsuance', 'publicliabilityinsurance', 'drivinginsurance'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('images', 'public');
            }
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['type'] = 2; // Set user type to 'driver'
        unset($data['_token']);
        User::create($data);
        return redirect('/admdriver')->with('success', 'File Uploaded Successfully');
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
        $data['data'] = User::find($id);
        $data['distnceprice'] = Cars::all();
        return view('admin.driver.edit')->with($data);
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

        $fileFields = ['image', 'hireandrewardinsurance', 'goodsintransitinsuance', 'publicliabilityinsurance', 'drivinginsurance'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('images', 'public');
            } else {
                unset($data[$field]); // Prevent wiping out existing documents if no new file is uploaded
            }
        }

        unset($data['_token']);
        $driver = User::find($id);
        $driver->update($data);

        // Activating a driver here also settles their registration application.
        if ((int) $driver->status === 1) {
            \App\Models\DriverProfile::where('user_id', $driver->id)
                ->where('application_status', \App\Models\DriverProfile::APPLICATION_PENDING)
                ->update([
                    'application_status'     => \App\Models\DriverProfile::APPLICATION_APPROVED,
                    'application_decided_at' => now(),
                    'application_decided_by' => auth()->id(),
                ]);
        }

        return redirect('/admdriver')->with('success', 'File Uploaded Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('/admdriver')->with('success', 'File Deleted Successfully');
    }
}
