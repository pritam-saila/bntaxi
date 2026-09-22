<?php

namespace App\Http\Controllers\admin;

use App\Models\FixedPrice;
use App\Models\Cars;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FixedPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['data'] = FixedPrice::with('car')->get();
        return view('admin.fixed_price.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['cars'] = Cars::all();
        return view('admin.fixed_price.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required',
            'destination_name' => 'required',
            'drop_price' => 'required|numeric',
            'pickup_price' => 'required|numeric',
            'keywords' => 'required'
        ]);

        $data = $request->all();
        unset($data['_token']);
        FixedPrice::create($data);

        return redirect('/admfixedprice')->with('success', 'Fixed Price Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['data'] = FixedPrice::findOrFail($id);
        $data['cars'] = Cars::all();
        return view('admin.fixed_price.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'car_id' => 'required',
            'destination_name' => 'required',
            'drop_price' => 'required|numeric',
            'pickup_price' => 'required|numeric',
            'keywords' => 'required'
        ]);

        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
        FixedPrice::findOrFail($id)->update($data);

        return redirect('/admfixedprice')->with('success', 'Fixed Price Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        FixedPrice::findOrFail($id)->delete();
        return redirect('/admfixedprice')->with('success', 'Fixed Price Deleted Successfully');
    }

    /**
     * Export fixed prices to CSV.
     */
    public function export()
    {
        $fixedPrices = FixedPrice::with('car')->get();
        $filename = "fixed_prices_" . date('Y-m-d_H-i-s') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['car_name', 'destination_name', 'drop_price', 'pickup_price', 'keywords'];

        $callback = function() use($fixedPrices, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($fixedPrices as $row) {
                fputcsv($file, [
                    $row->car->name ?? 'N/A',
                    $row->destination_name,
                    $row->drop_price,
                    $row->pickup_price,
                    $row->keywords
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import fixed prices from CSV.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            $header = fgetcsv($handle, 1000, ',');
            
            // Clean header column names to lowercase and trim spaces
            $header = array_map(function($col) {
                return strtolower(trim(str_replace(['"', "'"], '', $col)));
            }, $header);

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // Ensure data and header have matching lengths
                if (count($header) !== count($data)) {
                    continue;
                }
                $row = array_combine($header, $data);
                
                $carName = $row['car_name'] ?? '';
                $carId = $row['car_id'] ?? '';
                
                $car = null;
                if ($carName) {
                    $car = Cars::where('name', 'like', '%' . trim($carName) . '%')->first();
                }
                if (!$car && $carId) {
                    $car = Cars::find($carId);
                }
                
                if (!$car) {
                    $car = Cars::where('name', 'like', '%saloon%')->first() ?: Cars::first();
                }

                if ($car) {
                    FixedPrice::updateOrCreate(
                        [
                            'car_id' => $car->id,
                            'destination_name' => trim($row['destination_name'] ?? '')
                        ],
                        [
                            'drop_price' => floatval($row['drop_price'] ?? 0),
                            'pickup_price' => floatval($row['pickup_price'] ?? 0),
                            'keywords' => trim($row['keywords'] ?? '')
                        ]
                    );
                }
            }
            fclose($handle);
        }

        return redirect('/admfixedprice')->with('success', 'CSV Imported Successfully');
    }
}
