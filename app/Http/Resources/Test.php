<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TestQuestion;

class Test extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject_id' => $this->subject_id,
            'group_id' => $this->group_id,
            'start' => $this->start,
            'end' => $this->end,
            'title' => $this->title,
            'description' => $this->description,
            'questions' => TestQuestion::collection($this->questions),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
