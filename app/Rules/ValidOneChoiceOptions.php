<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidOneChoiceOptions implements Rule
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
        $rightAnswers = 0;

        if (is_array($value) && count($value) >= 2) {
            foreach ($value as $option) {
                if (@$option['is_right']) {
                    $rightAnswers++;
                }
            }

            if ($rightAnswers == 1) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.invalid_one_choice_options');
    }
}
