<?php

namespace App\Repository\Eloquent;

use App\Models\Prediction;
use App\Repository\PredictionRepositoryInterface;

class PredictionRepository extends BaseRepository implements PredictionRepositoryInterface
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
    public function __construct(Prediction $model)
    {
        $this->model = $model;
    }
}