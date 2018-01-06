<?php

namespace App\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class ApiInterface
{
    protected $client;

    function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://one.nhtsa.gov/webapi/api/SafetyRatings/']);
    }

    public function getVehicles($year, $manufacturer, $model)
    {
        $url_string = 'modelyear/'.$year.'/make/'.$manufacturer.'/model/'.$model.'?format=json';
        $response = $this->client->request('GET',$url_string);
        $body = $response->getBody();
        $json = $body->getContents();
        $array = json_decode($json,true);
        return $array;
    }

    public function getVehicleRating($vehicleIds)
    {
        foreach($vehicleIds as $vehicleId)
        {
            $url_string = 'VehicleId/'.$vehicleId.'?format=json';
            $promises[$vehicleId] = $this->client->getAsync($url_string);
        }
        
        $results = Promise\unwrap($promises);
        
        $returnArray = [];
        foreach ($results as $key => $resObject)
        {
            $body = $resObject->getBody();
            $json = $body->getContents();
            $array = json_decode($json,true);
            $returnArray[$key] = $array;
        }

        return $returnArray;
    }

}