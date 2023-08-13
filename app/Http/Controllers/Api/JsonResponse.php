<?php

namespace App\Http\Controllers\Api;

Trait JsonResponse{

    public function successResponse($message=null,$data=null,$code=200){
        return response()->json([
            'status'=>true,
            'message'=>$message,
            'data'=>$data
        ],$code);
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
