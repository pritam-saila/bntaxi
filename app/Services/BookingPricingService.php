<?php

namespace App\Services;

use App\Models\Cars;
use App\Models\Distances;
use App\Models\FixedPrice;
use App\Models\Setting;

/**
 * Single source of truth for journey distance + fare calculation.
 *
 * The pricing rules here are a faithful port of the original
 * PricingController::pricing() loop, so the customer quote page and the admin
 * "recalculate" action produce identical numbers.
 */
class BookingPricingService
{
    public function __construct(private RouteService $routes)
    {
    }

    /**
     * Build a full quote: route figures + a per-vehicle price list.
     *
     * @param array{
     *   pickup?: string, dropoff?: string, stops?: string[],
     *   is_return?: bool, only_car_id?: int|null
     * } $params
     */
    public function quote(array $params): array
    {
        $pickup = trim($params['pickup'] ?? '');
        $dropoff = trim($params['dropoff'] ?? '');
        $stops = array_values(array_filter(
            array_map('trim', $params['stops'] ?? []),
            fn ($s) => $s !== ''
        ));
        $isReturn = !empty($params['is_return']);

        // Ordered route: pickup -> stops -> dropoff
        $distarr = [];
        if ($pickup !== '') {
            $distarr[] = $pickup;
        }
        foreach ($stops as $s) {
            $distarr[] = $s;
        }
        if ($dropoff !== '') {
            $distarr[] = $dropoff;
        }

        $route = $this->routes->directions($distarr);
        $oneWayDistance = $route['distance_miles'];
        $oneWayDuration = $route['duration_minutes'];

        $distance = $oneWayDistance;
        $duration = $oneWayDuration;
        if ($isReturn) {
            $distance *= 2;
            $duration *= 2;
        }

        $isAirportTrip = $this->isAirportTrip($distarr);

        $cars = Cars::orderBy('sort_order', 'asc')->get();
        if (!empty($params['only_car_id'])) {
            $cars = $cars->where('id', $params['only_car_id'])->values();
        }

        $availableCars = [];
        foreach ($cars as $car) {
            if ($car->call_for_quote) {
                $car->call_for_quote = true;
                $car->calculated_price = 0;
                $availableCars[] = $car;
                continue;
            }

            $car->calculated_price = $this->priceForCar(
                $car,
                $distance,
                $distarr,
                $isReturn,
                $pickup,
                $dropoff,
                $isAirportTrip
            );
            $availableCars[] = $car;
        }

        return [
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'stops' => $stops,
            'is_return' => $isReturn,
            'distance' => $distance,
            'duration_minutes' => $duration,
            'one_way_distance' => $oneWayDistance,
            'one_way_duration' => $oneWayDuration,
            'distancearr' => $distarr,
            'is_airport_trip' => $isAirportTrip,
            'route' => $route,
            'cars' => $availableCars,
            'minimum' => $this->minimumDistanceCheck($distance),
        ];
    }

    /**
     * Fare for one vehicle. `$distanceForPricing` must already be doubled when
     * `$isReturn` is true (mirrors the historic behaviour).
     */
    public function priceForCar(
        Cars $car,
        float $distanceForPricing,
        array $distarr,
        bool $isReturn,
        string $pickup,
        string $dropoff,
        ?bool $isAirportTrip = null
    ): float {
        if ($car->call_for_quote) {
            return 0.0;
        }

        $isAirportTrip = $isAirportTrip ?? $this->isAirportTrip($distarr);

        [$matchedDrop, $matchedPickup, $matchedDropRecord, $matchedPickupRecord]
            = $this->matchFixedPrice($car, $pickup, $dropoff);

        if ($matchedDrop !== null || $matchedPickup !== null) {
            $localPrice = 0;
            if (count($distarr) > 2) {
                if ($matchedDrop !== null) {
                    $localLocations = array_slice($distarr, 0, count($distarr) - 1);
                    $localPrice = $this->routes->distanceMiles($localLocations) * ($car->mileage_multiplier ?? 4.0);
                } elseif ($matchedPickup !== null) {
                    $localLocations = array_slice($distarr, 1);
                    $localPrice = $this->routes->distanceMiles($localLocations) * ($car->mileage_multiplier ?? 4.0);
                }
            }

            if ($isReturn) {
                if ($matchedDrop !== null) {
                    $outwardPrice = $matchedDrop + $localPrice;
                    $returnPrice = $matchedDropRecord->pickup_price + $localPrice;
                } else {
                    $outwardPrice = $matchedPickup + $localPrice;
                    $returnPrice = $matchedPickupRecord->drop_price + $localPrice;
                }
                $calculatedPrice = $outwardPrice + $returnPrice;
            } else {
                $calculatedPrice = ($matchedDrop !== null ? $matchedDrop : $matchedPickup) + $localPrice;
            }
        } else {
            if ($car->mileage_multiplier) {
                $calculatedPrice = $distanceForPricing * $car->mileage_multiplier;
            } else {
                $distanceprice = Distances::where('car_id', $car->id)
                    ->where('end', '>=', intval($distanceForPricing))
                    ->where('start', '<=', intval($distanceForPricing))
                    ->first();

                if (!$distanceprice) {
                    $distanceprice = Distances::where('end', '>=', intval($distanceForPricing))
                        ->where('start', '<=', intval($distanceForPricing))
                        ->first();
                }

                $totdistanceprice = $distanceprice->price ?? 0;
                $airportSurcharge = $isAirportTrip ? ($car->airport_surcharge ?? 0) : 0;

                $calculatedPrice = $totdistanceprice + $car->price + $airportSurcharge;
                if ($isReturn) {
                    $calculatedPrice += $car->price + $airportSurcharge;
                }
            }
        }

        return round(max($calculatedPrice, $car->minprice), 2);
    }

    /**
     * @return array{0: ?float, 1: ?float, 2: ?FixedPrice, 3: ?FixedPrice}
     */
    private function matchFixedPrice(Cars $car, string $pickup, string $dropoff): array
    {
        $fixedPrices = FixedPrice::where('car_id', $car->id)->get();
        $matchedDrop = $matchedPickup = null;
        $matchedDropRecord = $matchedPickupRecord = null;

        foreach ($fixedPrices as $fp) {
            $keywords = array_filter(array_map('trim', explode(',', $fp->keywords)));

            foreach ($keywords as $kw) {
                if ($kw !== '' && stripos($dropoff, $kw) !== false) {
                    return [$fp->drop_price, null, $fp, null];
                }
            }
            foreach ($keywords as $kw) {
                if ($kw !== '' && stripos($pickup, $kw) !== false) {
                    return [null, $fp->pickup_price, null, $fp];
                }
            }
        }

        return [$matchedDrop, $matchedPickup, $matchedDropRecord, $matchedPickupRecord];
    }

    private function isAirportTrip(array $addresses): bool
    {
        foreach ($addresses as $location) {
            if (stripos($location, 'airport') !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * 8-mile minimum-distance rule.
     *
     * @return array{
     *   enforced: bool, minimum_miles: float, distance_miles: float,
     *   below_minimum: bool, blocked: bool, message: string
     * }
     */
    public function minimumDistanceCheck(float $distanceMiles): array
    {
        $enforced = (string) Setting::get('minimum_journey_enforced', '1') === '1';
        $min = (float) Setting::get('minimum_journey_miles', 8);
        $message = Setting::get(
            'minimum_journey_message',
            'Unfortunately, we do not accept bookings for journeys under 8 miles.'
        );

        $below = $distanceMiles > 0 && $distanceMiles < $min;

        return [
            'enforced' => $enforced,
            'minimum_miles' => $min,
            'distance_miles' => $distanceMiles,
            'below_minimum' => $below,
            'blocked' => $enforced && $below,
            'message' => $message,
        ];
    }
}
