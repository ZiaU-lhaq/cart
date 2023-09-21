<?php
// app/ApiResponseTrait.php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Send a success response.
     *
     * @param string|array $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($message = '' , $data = '', $status = 200)
    {
        return response()->json(['success' => true,'data' => $data, 'message' => $message], $status);
    }

    /**
     * Send an error response.
     *
     * @param string|array $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $status = 400)
    {
        return response()->json(['success' => false, 'message' => $message], $status);
    }
}
