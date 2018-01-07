<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Input;
use GuzzleHttp\Promise;
use App\Classes\ApiInterface;
use App\Classes\ResponseFormat;

class VehicleData extends Controller
{
    public function getdata($year, $manufacturer, $model)
    {

        $abcd = new ApiInterface();
        $vehicles = $abcd->getVehicles($year, $manufacturer, $model);
        $vehicleDescription =[];

        if($vehicles['Count']>0)
        {
            $vehicleIds = [];
            foreach ($vehicles['Results'] as $vehicle)
            {
                $vehicleIds[] = $vehicle['VehicleId'];
            }

            if(Input::get('withRating')=='true')
            {
                $vehicleDescription = $abcd->getVehicleRating($vehicleIds);
            }
        }

        $responseFormatObj = new ResponseFormat();

        if(Input::get('withRating')=='true')
        {
            $formattedOutput = $responseFormatObj->formatOutputWithRatings($vehicles,$vehicleDescription);
        }
        else
        {
            $formattedOutput = $responseFormatObj->formatOutput($vehicles);
        }

        return response()->json($formattedOutput);
    }


    public function postData(Request $request)
    {
        $inputData = $request->json()->all();
        if(isset($inputData['modelYear']) && isset($inputData['manufacturer']) && isset($inputData['model']))
        {
            $year = $inputData['modelYear'];
            $manufacturer = $inputData['manufacturer'];
            $model = $inputData['model'];
            $abcd = new ApiInterface();
            $vehicles = $abcd->getVehicles($year, $manufacturer, $model);
            $responseFormatObj = new ResponseFormat();
            $formattedOutput = $responseFormatObj->formatOutput($vehicles);
            return response()->json($formattedOutput);
        }
        else
        {
            $vehicles = [];
            $responseFormatObj = new ResponseFormat();
            $formattedOutput = $responseFormatObj->formatOutput($vehicles);
            return response()->json($formattedOutput);
        }
    }

}
