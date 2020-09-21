<?php

namespace App\Http\Requests;

use App\Rules\ValidMultiChoiceOptions;

class UpdateMultipleChoiceQuestionRequest extends Request
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
            'options' => [
                'required', 'array', new ValidMultiChoiceOptions
            ],
            'options.*.option' => 'required|max:100',
            'options.*.is_right' => 'required|boolean',
        ];
    }
}
