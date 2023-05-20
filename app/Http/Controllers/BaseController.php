<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param mixed $result
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function success(mixed $result, string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ], $code);
    }

    /**
     * return error response.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function error(string $error, array $errorMessages = [], int $code = 404): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $error,
            'data' => !empty($errorMessages) ? $errorMessages : null
        ], $code);
    }
}
