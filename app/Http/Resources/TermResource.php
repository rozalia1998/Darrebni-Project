<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
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
            'id' => $this->id,
            'question_content' => $this->question_content,
            'reference' => $this->reference,
            'subject_id' => $this->subject_id,
            'term_id' => $this->term_id,
            'correct_answer_id'=>$this->answers()->where('is_correct',true)->get('id'),
            'answers' => AnswerResource::collection($this->answers),
        ];
    }
}
