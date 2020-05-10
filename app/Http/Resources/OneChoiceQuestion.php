<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Option as OptionShortResource;

class OneChoiceQuestion extends JsonResource
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
            'topic_id' => $this->topic_id,
            'type' => $this->type,
            'question' => $this->question,
            'options' => OptionShortResource::collection($this->options),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
