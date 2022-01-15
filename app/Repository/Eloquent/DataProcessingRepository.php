<?php

namespace App\Repository\Eloquent;

use App\Models\Prediction;
use App\Repository\DataProcessingInterface;

class DataProcessingRepository extends BaseRepository implements DataProcessingInterface
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