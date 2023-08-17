<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonResponseTrait
{
 protected function failedValidation(Validator $validator)
 {
throw new HttpResponseException(response()->json([
'code' => 422,
'status' => 'false',
'errors' => $validator->errors(),
], 400));
}
}