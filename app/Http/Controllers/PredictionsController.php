<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Http\Resources\PredictionsResource;

class PredictionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PredictionsResource::collection(Prediction::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function show(Prediction $prediction)
    {
        return new PredictionsResource($prediction);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Give third party service to fetch data from files
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prediction $prediction)
    {
        $prediction->update([
            'scale' => $request->input('scale'),
            'city' => $request->input('city'),
            'date' => $request->input('date'),
            'value' => $request->input('value'),
            'time' => $request->input('time')
        ]);

        return new PredictionsResource($prediction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prediction $prediction)
    { //check deleting when there is many to many relationship
        $prediction->delete();
        return response(null, 204);
    }
}
