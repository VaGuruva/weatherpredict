<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeatherElementController;
use App\Http\Controllers\PredictionsController;
use App\Http\Controllers\DataProcessingController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\DataSourceRefreshController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Guarded routes
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function(Request $request){
        return $request->user();
    });

    Route::apiResource('/partners', PartnersController::class);
    Route::apiResource('/weather-elements', WeatherElementController::class);
    Route::apiResource('/predictions', PredictionsController::class);
    Route::get('/refresh-data', [DataSourceRefreshController::class, 'refreshPartnerData']);
});

//Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/predict-weather/{city}/{weatherElement}/{scale}/{date}', [ForecastController::class, 'getForeCast']);