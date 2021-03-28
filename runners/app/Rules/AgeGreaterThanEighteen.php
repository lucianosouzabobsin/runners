<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AgeGreaterThanEighteen implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $date = Carbon::createFromFormat('Y-m-d', $value);
        $age = $date->diffInYears(Carbon::now());

        return $age > 18;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'under 18 years of age.';
    }
}
