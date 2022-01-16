<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\PredictionAggregateServiceInterface;
use App\Interfaces\DateCheckServiceInterface;
use \Exception;

class ForecastController extends Controller
{
   private $predictionAggregateService;
   private $dateCheckService;
  
   public function __construct(PredictionAggregateServiceInterface $predictionAggregateService, DateCheckServiceInterface $dateCheckService)
   {
       $this->predictionAggregateService = $predictionAggregateService;
       $this->dateCheckService = $dateCheckService;
   }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getForeCast(Request $request)
    {
        try {
            $dateDaysCheck = $this->dateCheckService->dateCheck($request->route('date'));

            if($dateDaysCheck){
                return response()->json(['message' => "Cannot give forecast. Entered date 10 days more than current date."], 400);
            }

            $weatherElementPrediction = $this->predictionAggregateService->aggregate(
                $request->route('scale'), 
                $request->route('weatherElement'), 
                $request->route('city'),
                $request->route('date')
            );

            $response = [
                'prediction' => [
                    'city' => $request->route('city'),
                    'weatherElement' => $request->route('weatherElement'),
                    'predictionValue' => $weatherElementPrediction,
                    'scale' => $request->scale
                ]
            ];

            return response($response, 200);

        } catch (Exception $e) {
            $weatherElement = ucfirst($request->route('weatherElement'));
            $error = $e->getMessage();

            report($e);

            return response()->json(['message' => "ERROR: Failed to get $weatherElement prediction. REASON: $error . Internal Server Error."], 500);
        }

    }
}