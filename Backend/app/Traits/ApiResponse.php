<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse(
        mixed $data = null,
        string $message = 'Request successful.',
        int $status = 200,
        array $meta = []
    ): JsonResponse {
        $response = [
            'message' => $message,
            'data' => $data,
        ];

        if ($meta !== []) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $status);
    }

    protected function errorResponse(
        string $message,
        int $status = 400,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
