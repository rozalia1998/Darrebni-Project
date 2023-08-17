<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse as HttpJsonResponse;

Trait JsonResponse{

    public function successResponse($message = null, $data = null, $code = 200): HttpJsonResponse
{
    return response()->json([[
        'code' => $code,
        'message' => $message,
        'data' => 
             $data
    ]]
, $code);
}

public function errorResponse($message, $code = 400, $errors = [])
{
    return response()->json([
        'status' => false,
        'message' => $message,
        'code' => $code,
        'errors' => $errors
    ], $code);
}



    protected function notFoundResponse($message = 'Not found')
    {
        return $this->errorResponse($message, 404);
    }
}
