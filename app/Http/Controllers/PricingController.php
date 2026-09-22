<?php

namespace App\Http\Controllers;

use App\Services\BookingPricingService;
use App\Services\RouteService;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function __construct(
        private RouteService $routeService,
        private BookingPricingService $pricingService
    ) {
    }

    /**
     * Kept for backwards compatibility with any existing callers.
     *
     * @param  string[]  $locations  pickup -> ...vias -> dropoff
     */
    public function get_driving_distance(array $locations)
    {
        return $this->routeService->distanceMiles($locations);
    }

    public function pricing(Request $request)
    {
        $data = $request->all();

        $quote = $this->pricingService->quote([
            'pickup' => $data['pickup'] ?? '',
            'dropoff' => $data['dropoff'] ?? '',
            'stops' => $data['via'] ?? [],
            'is_return' => isset($data['is_return']) && $data['is_return'] == '1',
        ]);

        $val = [
            'distance' => $quote['distance'],
            'duration_minutes' => $quote['duration_minutes'],
            'distancearr' => $quote['distancearr'],
            'cars' => $quote['cars'],
            'pickup' => $quote['pickup'],
            'dropoff' => $quote['dropoff'],
            'pickup_date' => $data['pickup_date'] ?? '',
            'pickup_time' => $data['pickup_time'] ?? '',
            'return_date' => $data['return_date'] ?? '',
            'return_time' => $data['return_time'] ?? '',
            'is_return' => $quote['is_return'],
            'minimum' => $quote['minimum'],
        ];

        return view('goods.booking')->with($val);
    }
}
