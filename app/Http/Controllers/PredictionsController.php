<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Http\Resources\PredictionsResource;
use App\Repository\PredictionRepositoryInterface;
use App\Interfaces\DataProcessingServiceInterface;
use Throwable;
use \Exception;

class PredictionsController extends Controller
{
    private $predictionRepository;
    private $dataProcessingService;
  
    public function __construct(PredictionRepositoryInterface $predictionRepository, DataProcessingServiceInterface $dataProcessingService)
    {
        $this->predictionRepository = $predictionRepository;
        $this->dataProcessingService = $dataProcessingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $predictions = $this->predictionRepository->all();
            return PredictionsResource::collection($predictions);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Failed to get resource Internal Server Error.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\PredictionsResource
     */
    public function store(Request $request)
    {
        try {
            $prediction = $this->dataProcessingService->storePartnerPrediction($request->get('partner'));

            if(isset($prediction)){
                return PredictionsResource::collection([$prediction]);
            } else {
                return response()->json(['message' => "No predictions were found."], 400);
            }
            
        } catch (Exception $e) {
            report($e);
            return response()->json(['message' => 'Failed to create resource Internal Server Error.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prediction $prediction
     * @return \App\Http\Resources\PredictionsResource
     */
    public function show(Prediction $prediction)
    {
        try {
            $prediction = $this->predictionRepository->findById($prediction->id);
            return PredictionsResource::collection([$prediction]);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Failed to get resource Internal Server Error.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Prediction $prediction
     * @return \App\Http\Resources\PredictionsResource
     */
    public function update(Request $request, Prediction $prediction)
    {
        try {
            $updateResult = $this->predictionRepository->update($prediction->id, $request->all());
            if($updateResult){
                return PredictionsResource::collection([$prediction->fresh()]);
            }

        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Update failed Internal Server Error.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prediction $prediction)
    { 
        //check deleting when there is many to many relationship
        try{
            $deleteResult = $this->predictionRepository->deleteById($prediction->id);
            return response($deleteResult, 204);
        } catch (Throwable $e){
            report($e);
            return response()->json(['message' => 'Delete failed Internal Server Error.'], 500);
        }
    }
}
