<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * @param $status
     * @param $message
     * @param $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function success($status="success", $message=null,$data = [], int $statusCode=200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ],$statusCode);
    }


    /**
     * Function: return data
     * @param $status
     * @param $message
     * @param $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function error($status="error", $message=null, $data = [], int $statusCode=400):JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}
