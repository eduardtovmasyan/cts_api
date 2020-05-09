<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Option extends JsonResource
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
            'question_id' => $this->question_id,
            'option' => $this->option,
            'is_right' => $this->is_right,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
