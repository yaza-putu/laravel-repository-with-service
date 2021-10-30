<?php


namespace LaravelEasyRepository\Implementations;

use Exception;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Repository;

class Eloquent implements Repository
{
    /**
     * Fin an item by id
     * @param int $id
     * @return Model|null
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * find Or Fail
     * @param $id
     * @return mixed
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Return all items
     * @return Collection|null
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Return query builder instance to perform more manouvers
     * @return Builder|null
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * Create an item
     * @param array|mixed $data
     * @return Model|null
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a item
     * @param int|mixed $id
     * @param array|mixed $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * destroy many item with primary key
     * @param int|Model $id
     */
    public function destroy(array $id)
    {
        return $this->model->destroy($id);
    }

    /**
     * delete item
     * @param Model|int $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->delete($id);
    }
}
