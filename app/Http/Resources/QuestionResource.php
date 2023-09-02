<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AnswerResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'uuid'=>$this->uuid,
            'question_content'=>$this->question_content,
            'reference'=>$this->reference,
            'subject_id'=>$this->subject_id,
            'term_id'=>$this->term_id,
            'answers'=>AnswerResource::collection($this->answers)
        ];
    }
}
