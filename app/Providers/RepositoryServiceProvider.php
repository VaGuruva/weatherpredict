<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\BaseRepository; 
use App\Repository\EloquentRepositoryInterface; 
use App\Repository\Eloquent\UserRepository; 
use App\Repository\UserRepositoryInterface; 
use App\Repository\Eloquent\WeatherElementRepository; 
use App\Repository\WeatherElementRepositoryInterface; 
use App\Repository\Eloquent\PartnersRepository; 
use App\Repository\PartnersRepositoryInterface; 
use App\Repository\Eloquent\PredictionRepository; 
use App\Repository\PredictionRepositoryInterface; 
use App\Repository\Eloquent\DataProcessingRepository; 
use App\Repository\DataProcessingInterface; 

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(WeatherElementRepositoryInterface::class, WeatherElementRepository::class);
        $this->app->bind(PartnersRepositoryInterface::class, PartnersRepository::class);
        $this->app->bind(PredictionRepositoryInterface::class, PredictionRepository::class);
        $this->app->bind(DataProcessingInterface::class, DataProcessingRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
