<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class ValidTestQuestionTopic implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($subjectId)
    {
        $this->subjectId = $subjectId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table('questions')
            ->join('topics', 'topics.id', '=', 'questions.topic_id')
            ->where('questions.id', $value)
            ->where('topics.subject_id', $this->subjectId)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.invalid_test_question_topic');
    }
}
