<?php

namespace LaravelEasyRepository;

use Exception;

class Service
{
    /**
     * Repository object to perform CRUD fuctionalities. It is required in the
     * base Service class
     * @property Repository $mainRepository;
     */
    protected Repository $mainRepository;

    /**
     * The repository interface to use in this service. Will allow to use within
     * methods $this->repository. It will be resolved from the container
     * @property string $interfaceName;
     */
    protected $interfaceName = "";


    /**
     * Find an item by id
     * @param int $id
     * @return Model|null
     */
    public function find(int $id)
    {
        return $this->mainRepository->find($id);
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
     * Return query builder instance to perform more manouvers
     * @return Builder|null
     */
    public function query()
    {
        return $this->mainRepository->query();
    }

    /**
     * Create an item
     * @param array|mixed $data
     * @return Model|null
     */
    public function create($data)
    {
        return $this->mainRepository->create($data);
    }

    /**
     * Update a model
     * @param int|mixed $id
     * @param array|mixed $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        return $this->mainRepository->update($id, $data);
    }

    /**
     * Delete a model
     * @param int|Model $id
     */
    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }

    /**
     * multiple delete
     * @param array $id
     * @return mixed
     */
    public function destroy(array $id)
    {
        return $this->mainRepository->destroy($id);
    }

    /**
     * Initialize repository from the container
     * @return Repository|Exception|mixed
     */
    public function initialiseRepository()
    {
        if (
            $this->interfaceName == null ||
            $this->interfaceName == ""
        ) {
            throw new Exception("Please define the repository interface");
        }
        $this->repository = app()->make($this->interfaceName);
    }
}
