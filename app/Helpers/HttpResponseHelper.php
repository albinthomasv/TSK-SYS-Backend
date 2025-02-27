<?php

namespace App\Helpers;

class HttpResponseHelper
{
    /**
     * Return a success response.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = null, $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message ?? 'Request was successful.',
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = 'An error occurred.', $statusCode = 400, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
