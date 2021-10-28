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
    public function responseJson($status = true, $msg = '', $data = [], $code = null)
    {
        if(is_null($code)){
            $http_code = $status ? 200 : 400;
        }else{
            $http_code = $code;
        }

        return response()->json([
            'success' => $status,
            'code' => $http_code,
            'message' => $msg,
            'data' => $data,
        ], $http_code);
    }
}
