<?php

namespace App\Repositories;

use App\Repositories\Contract\BaseContract;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseContract
{
    protected Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find resource.
     *
     * @param mixed $id
     * @return Model
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create new resource.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update existing resource.
     *
     * @param mixed $id
     * @param array $data
     * @return Model
     */
    public function update($id, array $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * Delete existing resource.
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool
    {
        return (bool)$this->model->findOrFail($id)->delete();
    }

    /**
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function getAll(array $relations = [],$paginate=false)
    {
        if($paginate){
            return $this->model->with($relations)->paginate(5);
        }
        return $this->model->with($relations)->get();
    }

    /**
     * @param string $columnName
     * @param $columnValue
     * @param bool $allRecord
     * @return mixed
     */
    public function getColumnData(string $columnName, $columnValue, bool $allRecord = false)
    {
        if ($allRecord) {
            return $this->model->where($columnName, $columnValue)->get();
        }
        return $this->model->where($columnName, $columnValue)->first();
    }

    /**
     * Create multiple new resources.
     *
     * @param array $data
     * @return bool
     */
    public function createMany(array $data): bool
    {
        return $this->model->insert($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
