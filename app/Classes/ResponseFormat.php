<?php

namespace App\Classes;

class ResponseFormat
{
    public function formatOutput($vehicles)
    {
        $response = $this->formatResponse($vehicles);
        return $response;
    }

    public function formatOutputWithRatings($vehicles, $ratings)
    {
        $response = $this->formatResponse($vehicles, $ratings, true);
        return $response;
    }

    private function formatResponse($vehicles, $ratings=[], $withRatings=false)
    {
        $response = ['Count'=>0,'Results'=>[]];
        if(isset($vehicles['Count']))
        {
            $response['Count'] = $vehicles['Count'];
        }

        if(isset($vehicles['Results']))
        {
            foreach ($vehicles['Results'] as $vehicle)
            {
                $vehicleId=NULL;//test for null value here
                if(isset($vehicle['VehicleId']))
                    $vehicleId = $vehicle['VehicleId'];

                if($withRatings)
                    $tempArray=['CrashRating'=>'', 'Description'=>'', 'VehicleId'=>''];
                else
                    $tempArray=['Description'=>'', 'VehicleId'=>''];

                if(isset($withRatings) && isset($ratings[$vehicleId]['Results'][0]['OverallRating']))
                {
                    $tempArray['CrashRating'] = $ratings[$vehicleId]['Results'][0]['OverallRating'];
                }

                if(isset($vehicle['VehicleDescription']))
                {
                    $tempArray['Description'] = $vehicle['VehicleDescription'];
                }

                if(isset($vehicle['VehicleId']))
                {
                    $tempArray['VehicleId'] = $vehicle['VehicleId'];
                }

                $response['Results'][] = $tempArray;
            }
        }

        return $response;
    }

}