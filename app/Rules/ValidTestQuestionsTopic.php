<?php

namespace App\Rules;

use App\Question;
use Illuminate\Contracts\Validation\Rule;

class ValidTestQuestionsTopic implements Rule
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
        $questions = [];
        $topic_id = [];

        foreach ($value as $question) {
            $questions[] = $question['question_id'];
        }
        $data = Question::findMany($questions);

        foreach ($data as $key) {
            $topic_id[] = $key->topic_id;
        }

        $same = array_count_values($topic_id);

        return count($same) === 1;
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
