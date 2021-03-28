<?php

namespace App\Rules;

use App\Competition;
use App\Runner;
use Illuminate\Contracts\Validation\Rule;

class AgeAllowed implements Rule
{
    private $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
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
        $runner = Runner::getWithAge($this->request['runner_id']);
        $competition = Competition::where('id', $this->request['competition_id'])->get()->toArray();

        if (!empty($runner) && !empty($competition)) {
            return in_array($runner['age'], range($competition[0]['min_age'], $competition[0]['max_age']));
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Age not allowed.';
    }
}
