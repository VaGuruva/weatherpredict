<?php

namespace App\Repository\Eloquent;

use App\Models\Partner;
use App\Repository\PartnersRepositoryInterface;

class PartnersRepository extends BaseRepository implements PartnersRepositoryInterface
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
    public function __construct(Partner $model)
    {
        $this->model = $model;
    }
}