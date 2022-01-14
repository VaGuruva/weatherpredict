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
