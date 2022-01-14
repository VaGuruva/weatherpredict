<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Response;
use \Illuminate\Http\Request;
use App\Models\WeatherElement;
use App\Http\Resources\WeatherElementResource;
use App\Repository\WeatherElementRepositoryInterface;
use Throwable;

class WeatherElementController extends Controller
{
    private $weatherElementRepository;
  
    public function __construct(WeatherElementRepositoryInterface $weatherElementRepository)
    {
        $this->weatherElementRepository = $weatherElementRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $weatherElements = $this->weatherElementRepository->all();
            return WeatherElementResource::collection($weatherElements);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Failed to get resource Internal Server Error.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $weatherElement =  $this->weatherElementRepository->create($request->all());

            return WeatherElementResource::collection([$weatherElement]);

        } catch (Throwable $e) {
            report($e);

            return response()->json(['message' => 'Failed to create resource Internal Server Error.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeatherElement $weatherElement
     * @return \Illuminate\Http\Response
     */
    public function show(WeatherElement $weatherElement)
    {
        try {
            $weatherElement = $this->weatherElementRepository->findById($weatherElement->id);

            return WeatherElementResource::collection([$weatherElement]);
        } catch (Throwable $e) {
            report($e);

            return response()->json(['message' => 'Failed to get resource Internal Server Error.'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\WeatherElement $weatherElement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeatherElement $weatherElement)
    {
        try {
            $updateResult = $this->weatherElementRepository->update($weatherElement->id, $request->all());
            if($updateResult){
                return WeatherElementResource::collection([$weatherElement->fresh()]);
            }

        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Update failed Internal Server Error.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeatherElement  $weatherElement
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeatherElement $weatherElement)
    {
        try{
            $deleteResult = $this->weatherElementRepository->deleteById($weatherElement->id);
            return response($deleteResult, 204);

        } catch (Throwable $e){
            report($e);
            return response()->json(['message' => 'Delete failed Internal Server Error.'], 500);
        }
    }
}