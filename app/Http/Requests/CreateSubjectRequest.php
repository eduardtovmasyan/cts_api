<?php

namespace App\Http\Requests;

class CreateSubjectRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100|unique:subjects,name',
            'description' => 'string|max:65000|nullable',
        ];
    }
}
