<?php

namespace LaravelEasyRepository;

use Exception;

class Service
{

    /**
     * Find an item by id
     * @param mixed $id
     * @return Model|null
     */
    public function find($id)
    {
        return $this->mainRepository->find($id);
    }

    /**
     * Find an item by id or fail
     * @param mixed $id
     * @return Model|null
     */
    public function findOrFail($id)
    {
        return $this->mainRepository->findOrFail($id);
    }

    /**
     * Return all items
     * @return Collection|null
     */
    public function all()
    {
        return $this->mainRepository->all();
    }

    /**
     * Create an item
     * @param array|mixed $data
     * @return void
     */
    public function create($data)
    {
        $this->mainRepository->create($data);
    }

    /**
     * Update a model
     * @param int|mixed $id
     * @param array|mixed $data
     * @return void
     */
    public function update($id, array $data)
    {
        $this->mainRepository->update($id, $data);
    }

    /**
     * Delete a model
     * @param int|Model $id
     * @return void
     */
    public function delete($id)
    {
        $this->mainRepository->delete($id);
    }

    /**
     * multiple delete
     * @param array $id
     * @return void
     */
    public function destroy(array $id)
    {
        $this->mainRepository->destroy($id);
    }
}
