<?php

namespace App\Http\Controllers;
use App\Interfaces\DataProcessingServiceInterface;
use \Exception;

class DataSourceRefreshController extends Controller
{
    private $dataProcessingService;
  
   public function __construct(DataProcessingServiceInterface $dataProcessingService)
   {
       $this->dataProcessingService = $dataProcessingService;
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshPartnerData()
    {
        try {
            $this->dataProcessingService->refreshPartnerPredictions();
            $response = [
                'DataRefresh' => [
                    'message' => 'Success',
                ]
            ];

            return response($response, 200);

        } catch (Exception $e) {
            report($e);
            return response()->json(['message' => 'Failed to update resource Internal Server Error.'], 500);
        }
    }
}