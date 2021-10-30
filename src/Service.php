<?php

namespace LaravelEasyRepository;

use Exception;

class Service
{
    /**
     * Repository object to perform CRUD fuctionalities. It is required in the
     * base Service class
     * @property Repository $repository;
     */
    protected Repository $repository;

    /**
     * Find an item by id
     * @param int $id
     * @return Model|null
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Find an item by id
     * @param int $id
     * @return Model|null
     */
    public function findOrFail(int $id)
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Return all items
     * @return Collection|null
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Return query builder instance to perform more manouvers
     * @return Builder|null
     */
    public function query()
    {
        return $this->repository->query();
    }

    /**
     * Create an item
     * @param array|mixed $data
     * @return Model|null
     */
    public function create($data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update a model
     * @param int|mixed $id
     * @param array|mixed $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a model
     * @param int|Model $id
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
