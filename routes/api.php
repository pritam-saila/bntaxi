<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PricingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// checkifinaddress

Route::post('/checkifinaddress', [PricingController::class, 'checkifinaddress']);
Route::post('/gettime', [PricingController::class, 'gettime']);


Route::get('/run-storage-link', function () {
    try {
        Artisan::call('storage:link');

        return response()->json([
            'status' => 'success',
            'message' => 'Storage link created successfully',
            'output' => Artisan::output()
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
});