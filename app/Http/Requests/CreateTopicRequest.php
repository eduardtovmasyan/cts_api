<?php

namespace App\Http\Requests;

class CreateTopicRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100|unique:topics,name',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'string|max:65000|nullable',
        ];
    }
}
