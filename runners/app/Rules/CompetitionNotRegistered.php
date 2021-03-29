<?php

namespace App\Rules;

use App\Services\ServiceCompetition;
use Illuminate\Contracts\Validation\Rule;

class CompetitionNotRegistered implements Rule
{
    private $request;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request, ServiceCompetition $serviceCompetition)
    {
        $this->request = $request;
        $this->serviceCompetition = $serviceCompetition;
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
        return $this->serviceCompetition->existCompetition($this->request) == false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Already registered.';
    }
}
