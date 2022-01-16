<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
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
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Find model by id.
     *
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * Find a model.
     *
     * @param array $payload
     * @return Model
     */
    public function findByColumn(string $column, string $value): ?Model
    {
        $model = $this->model->where($column , '=', $value)->first();

        return $model;
    }

    /**
     * Find a model collection.
     *
     * @param array $payload
     * @return Collection
     */
    public function findBy(array $payload): Collection
    {
        $name = key($payload);
        $value = $payload[$name];

        $modelCollection = $this->model->where($name , 'LIKE', '%'.$value.'%')->get();
        return $modelCollection;
    }

    /**
     * Find a model collection.
     *
     * @param array $payload
     * @return Collection
     */
    public function findBy2Columns(array $column1, array $column2): Collection
    {
        $column1_name = key($column1);
        $column1_value = $column1[$column1_name];

        $column2_name = key($column2);
        $column2_value = $column2[$column2_name];

        $modelCollection = $this->model
            ->whereRaw("LOWER({$column1_name}) = '". strtolower($column1_value)."'") 
            ->whereRaw("LOWER({$column2_name}) = '". strtolower($column2_value)."'") 
            ->get();

        return $modelCollection;
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);

        return $model;
    }

    /**
     * Update existing model.
     *
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(int $modelId, array $payload): bool
    {
        $model = $this->findById($modelId);

        return $model->update($payload);
    }

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }
}