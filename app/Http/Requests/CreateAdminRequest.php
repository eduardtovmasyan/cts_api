<?php

namespace App\Http\Requests;

class CreateAdminRequest extends Request
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
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|numeric|unique:users,phone',
            'password' => 'required|min:6',
            'is_active' => 'required|boolean',
        ];
    }
}
