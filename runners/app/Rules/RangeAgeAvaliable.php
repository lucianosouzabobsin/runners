<?php

namespace App\Rules;

use App\Competition;
use Illuminate\Contracts\Validation\Rule;

class RangeAgeAvaliable implements Rule
{
    private $messageErrorRangeAge;

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
        if (!isset($value[1])) {
            $value[1] = '0';
        }

        $min_age = trim($value[0]);
        $max_age = trim($value[1]);
        $rangesAgesBase = Competition::getRangeAges();

        foreach ($rangesAgesBase as $range) {
            $this->messageErrorRangeAge .= sprintf(' %d,%d or',$range['min_age'], $range['max_age']);

            if ($range['min_age'] == $min_age && $range['max_age'] == $max_age) {
                return true;
            }
        }

        $this->messageErrorRangeAge = substr($this->messageErrorRangeAge, 0, -3);

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'range must be'.$this->messageErrorRangeAge.'.';
    }
}
