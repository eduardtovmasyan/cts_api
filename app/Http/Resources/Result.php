<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Result extends JsonResource
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
            'score' => $this->score,
            'user_id' => $this->user_id,
            'test_id' => $this->test_id,
            'answers' => $this->answers,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
