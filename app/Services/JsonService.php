<?php

namespace App\Services;

/**
 * Description of JsonService
 *
 * @author tony
 */
class JsonService
{
    public static function jsonSuccess($message, $data)
    {
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function jsonError($message, $code = 422)
    {
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
