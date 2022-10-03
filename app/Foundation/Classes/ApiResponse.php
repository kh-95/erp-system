<?php

namespace App\Foundation\Classes;

class ApiResponse
{

    public static function success($result, $code = 200, $headers = [])
    {
        if (null === $result) $code = 204;
            $response = [
                'code' => $code,
                'data' => $result,
            ];
        return response()->json($response, $code, $headers);
    }

    public static function error($errors = null, $code = 404, $exception = [])
    {
        $response = [
            'code' => $code,
            'errors' => $errors,
            'exception' => $exception
        ];
        return response()->json($response, $code);
    }

}
