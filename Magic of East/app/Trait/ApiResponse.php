<?php

namespace App\Trait;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public static function response($data, $message, $code = 200, $meta = null): JsonResponse
    {
        $response = ['message' => $message, 'status' => $code];
        if ($meta) {
            $response = array_merge(['meta' => $meta], $response);
        }
        $response = array_merge(['data' => $data], $response);
        return response()->json($response, $code);
    }
    protected function SuccessOne($data, $resource, $message = 'Success', $code = 200, $Additional = null): JsonResponse
    {
        if ($resource) {
            $data = $Additional ? new $resource($data, $Additional) : new $resource($data);
        }
        return $this->response($data, $message, $code);
    }
    protected function SuccessMany($data, $resource, $message = 'Success', $code = 200): JsonResponse
    {
        $paginationMeta = $this->getPaginationMeta($data);
        $response = $resource::collection($data);
        return $this->response($response, $message, $code, $paginationMeta);
    }

    protected function getPaginationMeta($paginator): array
    {
        return [
            'per_page' => $paginator->perPage(),
            'count' => $paginator->count(),
            'current_page' => $paginator->currentPage(),
            'path' => $paginator->path(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'prev' => $paginator->previousPageUrl(),
            'next' => $paginator->nextPageUrl(),
        ];
    }
    public static function Error($data = null, $message = 'Error', $code = 200): JsonResponse
    {
        return response()->json(
            $message,
            $code
        );
    }
}
