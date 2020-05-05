<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Topic extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'subject' => SubjectShortResource::make($this->subject),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function topicBelongs(){
        return $this->belongsTo('App\Subject','subject_id','id');
    }
}
