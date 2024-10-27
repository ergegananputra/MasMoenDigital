<?php

namespace App\Helpers;

class ResponseJSON
{
    public static function success($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message = 'Error', $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }

    public static function unauthorized($message = 'Unauthorized', $code = 401)
    {
        return response()->json([
            'status' => 'Unauthorized',
            'message' => $message
        ], $code);
    }
}
