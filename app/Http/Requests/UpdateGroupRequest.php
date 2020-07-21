<?php

namespace App\Http\Requests;

class UpdateGroupRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100|unique:groups,name,' . $this->route('group'),
            'description' => 'string|max:65000|nullable',
        ];
    }
}
