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
    public function __construct(ApiInterface $apiInterface, ResponseFormat $responseFormat)
    {
        $this->apiInterface = $apiInterface;
        $this->responseFormat = $responseFormat;
    }

    public function getData($year, $manufacturer, $model)
    {
        $vehicles = $this->apiInterface->getVehicles($year, $manufacturer, $model);
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
                $vehicleDescription = $this->apiInterface->getVehicleRating($vehicleIds);
            }
        }

        if(Input::get('withRating')=='true')
        {
            $formattedOutput = $this->responseFormat->formatOutputWithRatings($vehicles,$vehicleDescription);
        }
        else
        {
            $formattedOutput = $this->responseFormat->formatOutput($vehicles);
        }

        return response()->json($formattedOutput);
    }


    public function postData(Request $request)
    {
        $inputData = $request->json()->all();
        $vehicles = [];
        if(isset($inputData['modelYear']) && isset($inputData['manufacturer']) && isset($inputData['model']))
        {
            $year = $inputData['modelYear'];
            $manufacturer = $inputData['manufacturer'];
            $model = $inputData['model'];
            $vehicles = $this->apiInterface->getVehicles($year, $manufacturer, $model);
        }
        
        $formattedOutput = $this->responseFormat->formatOutput($vehicles);
        return response()->json($formattedOutput);
    }

}
