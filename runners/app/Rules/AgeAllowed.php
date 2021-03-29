<?php

namespace App\Rules;

use App\Services\ServiceCompetition;
use App\Services\ServiceRunner;
use Illuminate\Contracts\Validation\Rule;

class AgeAllowed implements Rule
{
    protected $request;
    protected $serviceRunner;
    protected $serviceCompetition;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        $request,
        ServiceRunner $serviceRunner,
        ServiceCompetition $serviceCompetition)
    {
        $this->request = $request;
        $this->serviceRunner = $serviceRunner;
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
        $runner = $this->serviceRunner->getWithAge($this->request['runner_id']);
        $competition = $this->serviceCompetition->getCompetition($this->request['competition_id']);

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
