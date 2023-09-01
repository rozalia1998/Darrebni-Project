<?php
namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonResponseTrait
{
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
             'code' => 422,
             'status' => false,
             'errors' => $validator->errors(),
             ], 422));
    }
}
