<?php

namespace App\Services;

class PricingService
{
    public function get_lat_long($address){

        $address = urlencode($address);
        $apiKey = env('GOOGLE_API_KEY');
        
        $json = @file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=".$apiKey."&components=country:GB");
    
        if ($json) {
            $data = json_decode($json);
            if (!empty($data) && $data->status === 'OK' && isset($data->results[0])) {
                $lat = $data->results[0]->geometry->location->lat;
                $long = $data->results[0]->geometry->location->lng;
                return [$lat, $long];
            }
        }
        return [0, 0];
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit = 'M') {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
      
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
