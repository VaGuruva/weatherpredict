<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Response;
use \Illuminate\Http\Request;
use App\Models\WeatherElement;
use App\Http\Resources\WeatherElementResource;
use App\Repository\WeatherElementRepositoryInterface;

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
        $weatherElements = $this->weatherElementRepository->all();

        return WeatherElementResource::collection($weatherElements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $weatherElement =  $this->weatherElementRepository->create([
            'scale' => $request->input('scale'),
            'type' => $request->input('type'),
        ]);

        return WeatherElementResource::collection($weatherElement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeatherElement $weatherElement
     * @return \Illuminate\Http\Response
     */
    public function show(WeatherElement $weatherElement)
    {
        return WeatherElementResource::collection([$weatherElement]);
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
        $weatherElement->update([
            'scale' => $request->input('scale'),
            'type' => $request->input('type'),
        ]);

        return WeatherElementResource::collection([$weatherElement]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeatherElement  $weatherElement
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeatherElement $weatherElement)
    {
        $weatherElement->delete();
        return response(null, 204);
    }
}