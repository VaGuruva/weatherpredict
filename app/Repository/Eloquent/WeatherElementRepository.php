<?php

namespace App\Repository\Eloquent;

use App\Models\WeatherElement;
use App\Repository\WeatherElementRepositoryInterface;

class WeatherElementRepository extends BaseRepository implements WeatherElementRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(WeatherElement $model)
    {
        $this->model = $model;
    }
}