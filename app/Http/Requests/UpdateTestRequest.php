<?php

namespace App\Http\Requests;

use App\Rules\ValidTestQuestionTopic;

class UpdateTestRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'group_id' => 'nullable|exists:groups,id',
            'start' => 'required|date|after:now',
            'end' => 'required|date|after:start',
            'description' => 'nullable|string|max:65000',
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.score' => 'required|integer|between:1,100',
            'questions.*.id' => [
                'required', 'exists:questions,id',  new ValidTestQuestionTopic($request->subject_id)
            ],
        ];
    }
}
