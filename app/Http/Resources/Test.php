<?php

namespace App\Http\Resources;

use App\Http\Resources\TestQuestion;
use App\Http\Resources\TesteeGroupShort;
use App\Http\Resources\TesteeSubjectShort;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'subject' => TesteeSubjectShort::make($this->subject),
            'group' => TesteeGroupShort::make($this->group),
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
