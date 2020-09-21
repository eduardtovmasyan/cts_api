<?php

namespace App\Http\Requests;

class UpdateAdminRequest extends Request
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
            'email' => 'required|email|unique:users,email,' . $this->route('admin'),
            'phone' => 'nullable|numeric|unique:users,phone,' . $this->route('admin'),
            'password' => 'required|min:6',
            'is_active' => 'required|boolean',
        ];
    }
}
