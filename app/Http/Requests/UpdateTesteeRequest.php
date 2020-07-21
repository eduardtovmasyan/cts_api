<?php

namespace App\Http\Requests;

class UpdateTesteeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('testee'),
            'phone' => 'nullable|numeric|unique:users,phone,' . $this->route('testee'),
            'password' => 'required|min:6',
            'is_active' => 'required|boolean',
            'group_id' => 'required|exists:groups,id',
        ];
    }
}
