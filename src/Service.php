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
        return $this->mainInterface->find($id);
    }

    /**
     * Find an item by id or fail
     * @param mixed $id
     * @return Model|null
     */
    public function findOrFail($id)
    {
        return $this->mainInterface->findOrFail($id);
    }

    /**
     * Return all items
     * @return Collection|null
     */
    public function all()
    {
        return $this->mainInterface->all();
    }

    /**
     * Create an item
     * @param array|mixed $data
     * @return void
     */
    public function create($data)
    {
        $this->mainInterface->create($data);
    }

    /**
     * Update a model
     * @param int|mixed $id
     * @param array|mixed $data
     * @return void
     */
    public function update($id, array $data)
    {
        $this->mainInterface->update($id, $data);
    }

    /**
     * Delete a model
     * @param int|Model $id
     * @return void
     */
    public function delete($id)
    {
        $this->mainInterface->delete($id);
    }

    /**
     * multiple delete
     * @param array $id
     * @return void
     */
    public function destroy(array $id)
    {
        $this->mainInterface->destroy($id);
    }
}
