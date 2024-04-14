<?php


namespace LaravelEasyRepository;

use LaravelEasyRepository\Traits\ResultService;

class ServiceApi implements BaseService
{
    use ResultService;

    protected $title = "";
    protected $create_message = "created successfully";
    protected $update_message = "updated successfully";
    protected $delete_message = "deleted successfully";


    /**
     * find by id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|ServiceApi|ResultService|null
     */
    public function find($id)
    {
        try {
            $result = $this->mainRepository->find($id);
            return $this->setData($result)
                        ->setCode(200);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }


    /**
     * find or fail by id
     * @param $id
     * @return ServiceApi|ResultService|mixed
     */
    public function findOrFail($id)
    {
        try {
            $result = $this->mainRepository->findOrFail($id);
            return $this->setData($result)
                ->setCode(200);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }


    /**
     * all data
     * @return \Illuminate\Database\Eloquent\Collection|ServiceApi|ResultService|null
     */
    public function all()
    {
        try {
            $result = $this->mainRepository->all();;
            return $this->setData($result)
                ->setCode(200);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }


    /**
     * create data
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|ServiceApi|ResultService|null
     */
    public function create($data)
    {
        try {
            $data = $this->mainRepository->create($data);
            return $this->setMessage($this->title." ".$this->create_message)
                ->setCode(200)
                ->setData($data);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Update data
     * @param int|mixed $id
     * @param array|mixed $data
     * @return bool|mixed
     */
    public function update($id, array $data)
    {
        try {
            $this->mainRepository->update($id, $data);
            return $this->setMessage($this->title." ".$this->update_message)
                ->setCode(200);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Delete data by id
     * @param int|Model $id
     */
    public function delete($id)
    {
        try {
            $this->mainRepository->delete($id);
            return $this->setMessage($this->title." ".$this->delete_message)
                ->setCode(200);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * multiple delete
     * @param array $id
     * @return mixed
     */
    public function destroy(array $id)
    {
        try {
            $this->mainRepository->destroy($id);
            return $this->setMessage($this->title." ".$this->delete_message)
                ->setCode(200);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
}
