<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidTestQuestionsTotalScore implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $score = 0;

        foreach ($value as $question) {
            $score += $question['score'] ?? 0;
        }

        return $score === 100;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.invalid_test_questions_total_score');
    }
}
