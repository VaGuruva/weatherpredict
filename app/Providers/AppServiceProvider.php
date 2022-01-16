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
use App\Interfaces\DataProcessingServiceInterface;
use App\Services\DataProcessingService;
use App\Interfaces\DateCheckServiceInterface;
use App\Services\DateCheckService;

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
        $this->app->bind(DataProcessingServiceInterface::class, DataProcessingService::class);
        $this->app->bind(DateCheckServiceInterface::class, DateCheckService::class);
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
