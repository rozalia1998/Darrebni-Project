<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'name'=>$this->name,
            'Specialization_id'=>$this->specialization_id,
            'has_master'=>$this->has_master,
            'has_graduation'=>$this->has_graduation
        ];
    }
}
