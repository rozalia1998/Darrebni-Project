<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse as HttpJsonResponse;

Trait JsonResponse{

    public function successResponse($message = null, $data = null, $code = 200): HttpJsonResponse
{
    return response()->json([
        'status' => true,
        'message' => $message,
        'data' => [
             $data
        ]
    ], $code);
}

    public function errorResponse($message,$code){
        return response()->json([
            'status'=>false,
            'message'=>$message,
        ],$code);
    }

    protected function notFoundResponse($message = 'Not found')
    {
        return $this->errorResponse($message, 404);
    }
}
