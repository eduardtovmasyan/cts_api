<?php

namespace App\Http\Requests;

class UpdateShortAnswerQuestionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topic_id' => 'required|exists:topics,id',
            'question' => 'required|string|max:65000',
            'answer' => 'required|string|max:255',
        ];
    }
}
