<?php

namespace App\Rules;

use App\Runner;
use Illuminate\Contracts\Validation\Rule;

class RunnerExists implements Rule
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
        return !empty($runner);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Runner not exists.';
    }
}
