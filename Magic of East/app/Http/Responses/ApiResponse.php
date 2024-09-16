<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function SuccessOne($data, $resource = null, $message = 'Success', $code = 200): JsonResponse
    {
        $final_data = ($resource ? new $resource($data) : $data);
        return response()->json(
            [
                'status' => 1,
                'data' => $final_data,
                'message' => $message,
                'code' => $code,
            ]
        );
    }

    public static function SuccessMany($data, $resource = null, $message = 'Success', $code = 200): JsonResponse
    {
        $final_data = ($resource ? $resource::collection($data) : $data);
        return response()->json(
            [
                'status' => 1,
                'data' => $final_data,
                'message' => $message,
                'code' => $code,
            ]
        );
    }

    public static function Error($data = null, $message = 'Error', $code = 200): JsonResponse
    {
        return response()->json(
            [
                'status' => 0,
                'data' => $data,
                'message' => $message,
                'code' => $code,
            ]
        );
    }
}
