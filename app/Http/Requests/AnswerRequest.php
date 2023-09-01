<?php

namespace App\Http\Requests;

use App\Http\Traits\JsonResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    use JsonResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

            return [
                'answer_content'=>'required|string',
                'question_id'=>'required|integer|exists:questions,id',
                'is_correct'=>'required|boolean'
            ];

    }
}
