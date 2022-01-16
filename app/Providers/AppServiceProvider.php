<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CsvDataInterface;
use App\Services\CsvDataService;
use App\Interfaces\JsonDataInterface;
use App\Services\JsonDataService;
use App\Interfaces\XmlDataInterface;
use App\Services\XMLDataService;
use App\Interfaces\PredictionAggregateServiceInterface;
use App\Services\PredictionAggregateService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CsvDataInterface::class, CsvDataService::class);
        $this->app->bind(JsonDataInterface::class, JsonDataService::class);
        $this->app->bind(XmlDataInterface::class, XMLDataService::class);
        $this->app->bind(PredictionAggregateServiceInterface::class, PredictionAggregateService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
