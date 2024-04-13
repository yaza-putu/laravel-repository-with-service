<?php

namespace LaravelEasyRepository\Traits;


/**
 * Trait Response
 * @package App\Traits
 */
trait Response
{
    /**
     * handel response json
     * @param bool $status
     * @param string $msg
     * @param array $data
     * @param null $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson($msg = '', $data = [], $code = null, $errors = [])
    {
        if(is_null($code)){
            $http_code = 200;
        }else{
            $http_code = $code;
        }

        return response()->json([
            'code' => $http_code,
            'message' => $msg,
            'data' => $data,
            'errors' => $errors
        ], $http_code);
    }
}
