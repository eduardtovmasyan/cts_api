<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class ValidTestQuestionsTopic implements Rule
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
        $questionSubject = DB::table('questions')
            ->join('topics', 'topics.id', '=', 'questions.topic_id')
            ->first();

        return  $questionSubject->subjectId === $this->subjectId;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.invalid_test_questions_topic');
    }
}
