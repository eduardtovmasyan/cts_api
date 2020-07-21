<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateResultRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'test_id' => 'required|exists:tests,id',
            'answers' => 'required|array',
            'answers.*.answer' => 'required',
            'answers.*.question_id' => [
                'required',
                Rule::exists('test_questions')->where(function ($query) use ($request) {
                    $query->where('test_id', $request->test_id);
                }),
            ],
        ];
    }
}
