<?php

namespace App\Services;

/**
 * Thin wrapper around the Google Directions / Geocoding APIs.
 *
 * Every booking distance/duration figure in the system should come from here so
 * the customer quote flow and the admin recalculation flow stay in lock-step.
 */
class RouteService
{
    private const METERS_PER_MILE = 1609.34;

    /**
     * Driving distance + duration for an ordered list of addresses
     * (pickup -> stop 1 -> stop 2 -> ... -> dropoff).
     *
     * @param  string[]  $addresses
     * @return array{
     *   ok: bool,
     *   distance_miles: float,
     *   duration_minutes: int,
     *   status: string,
     *   error: ?string,
     *   legs: array<int, array{distance_miles: float, duration_minutes: int, start: string, end: string}>
     * }
     */
    public function directions(array $addresses): array
    {
        $addresses = array_values(array_filter(array_map('trim', $addresses), fn ($a) => $a !== ''));

        $empty = [
            'ok' => false,
            'distance_miles' => 0.0,
            'duration_minutes' => 0,
            'status' => 'INSUFFICIENT_STOPS',
            'error' => null,
            'legs' => [],
        ];

        if (count($addresses) < 2) {
            return $empty;
        }

        $apiKey = env('GOOGLE_API_KEY');
        $points = $addresses;
        $origin = urlencode(array_shift($points));
        $destination = urlencode(array_pop($points));

        $waypointsQuery = '';
        if (!empty($points)) {
            $waypointsQuery = '&waypoints=' . urlencode(implode('|', $points));
        }

        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$origin}&destination={$destination}{$waypointsQuery}&units=imperial&key={$apiKey}";

        $json = @file_get_contents($url);
        if ($json === false) {
            return array_merge($empty, ['status' => 'REQUEST_FAILED', 'error' => 'Could not reach the routing service.']);
        }

        $data = json_decode($json);
        if (!$data || ($data->status ?? '') !== 'OK' || empty($data->routes[0]->legs)) {
            return array_merge($empty, [
                'status' => $data->status ?? 'UNKNOWN',
                'error' => $data->error_message ?? 'No route could be calculated for these addresses.',
            ]);
        }

        $totalMeters = 0;
        $totalSeconds = 0;
        $legs = [];

        foreach ($data->routes[0]->legs as $leg) {
            $totalMeters += $leg->distance->value;
            $totalSeconds += $leg->duration->value;
            $legs[] = [
                'distance_miles' => round($leg->distance->value / self::METERS_PER_MILE, 2),
                'duration_minutes' => (int) round($leg->duration->value / 60),
                'start' => $leg->start_address ?? '',
                'end' => $leg->end_address ?? '',
            ];
        }

        return [
            'ok' => true,
            // Full precision on purpose: callers multiply this by a per-mile rate,
            // so pre-rounding here would drift the fare by a few pence. Round for
            // display at the call site instead.
            'distance_miles' => $totalMeters / self::METERS_PER_MILE,
            'duration_minutes' => (int) round($totalSeconds / 60),
            'status' => 'OK',
            'error' => null,
            'legs' => $legs,
        ];
    }

    /**
     * Distance only, in miles. Returns 0.0 when it cannot be determined
     * (matches the historic behaviour of PricingController::get_driving_distance).
     *
     * @param  string[]  $addresses
     */
    public function distanceMiles(array $addresses): float
    {
        return $this->directions($addresses)['distance_miles'];
    }

    /**
     * Geocode a UK address to [lat, lng]. Returns [0, 0] on failure.
     *
     * @return array{0: float, 1: float}
     */
    public function geocode(string $address): array
    {
        $apiKey = env('GOOGLE_API_KEY');
        $json = @file_get_contents(
            'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address)
            . '&key=' . $apiKey . '&components=country:GB'
        );

        if ($json) {
            $data = json_decode($json);
            if (!empty($data) && ($data->status ?? '') === 'OK' && isset($data->results[0])) {
                return [
                    (float) $data->results[0]->geometry->location->lat,
                    (float) $data->results[0]->geometry->location->lng,
                ];
            }
        }

        return [0.0, 0.0];
    }

    /**
     * Format a minute count as "1h 24m" / "45m".
     */
    public static function humanDuration(?int $minutes): string
    {
        $minutes = (int) $minutes;
        if ($minutes <= 0) {
            return '—';
        }
        $h = intdiv($minutes, 60);
        $m = $minutes % 60;
        return $h > 0 ? trim("{$h}h {$m}m") : "{$m}m";
    }
}
