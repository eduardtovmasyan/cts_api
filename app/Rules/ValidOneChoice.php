<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidOneChoice implements Rule
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
        if (!empty($value) && is_array($value)) {

            foreach ($value as $option) {
                if ($option['is_right'] == true) {
                    $true[] = $option['is_right'];
                }
            }

            if (count($true) < 2) {
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
        return 'There should be only one right answer.';
    }
}
