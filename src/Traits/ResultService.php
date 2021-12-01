<?php


namespace LaravelEasyRepository\Traits;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

trait ResultService
{
    private $result = null;
    private $status = false;
    private $message = null;
    private $code = null;

    /**
     * set result output
     * @param $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * get result
     * @return null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * set status
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * get status
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * set message
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * get message
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * set code
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * get code
     * @return null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Exception Response
     *
     * @param Exception $exception
     * @return ResultService
     */
    public function exceptionResponse(Exception $exception)
    {
        if ($exception instanceof QueryException) {
            if ($exception->errorInfo[1] == 1451) {
                return $this->setStatus(false)
                    ->setMessage('Data masih terpakai di Data Lain!')
                    ->setCode(400);
            }
        }
        if ($exception instanceof ModelNotFoundException) {
            if (!request()->expectsJson()) {
                return abort(404);
            }
            return $this->setStatus(false)
                ->setMessage('Data tidak ditemukan!')
                ->setCode(404);
        }
        if (config('app.debug')) {
            return $this->setStatus(false)
                ->setMessage($exception->getMessage(). 'on line '. $exception->getLine() .'on file '. $exception->getFile())
                ->setCode(400);
        }

        return $this->setStatus(false)
            ->setMessage('Terjadi suatu kesalahan!')
            ->setCode(400);
    }
}
