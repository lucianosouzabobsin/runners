<?php

namespace App\Rules;

use App\Services\ServiceCompetition;
use App\Services\ServiceRunner;
use App\Services\ServiceRunnerCompetition;
use Illuminate\Contracts\Validation\Rule;

class CanRunOnDate implements Rule
{
    protected $request;
    protected $serviceRunner;
    protected $serviceCompetition;
    protected $serviceRunnerCompetition;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        $request,
        ServiceRunner $serviceRunner,
        ServiceCompetition $serviceCompetition,
        ServiceRunnerCompetition $serviceRunnerCompetition)
    {
        $this->request = $request;
        $this->serviceRunner = $serviceRunner;
        $this->serviceCompetition = $serviceCompetition;
        $this->serviceRunnerCompetition = $serviceRunnerCompetition;
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
            return $this->serviceRunnerCompetition->canRunOnDate($runner['id'], $competition[0]['date']);
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
        return 'Can not run on date.';
    }
}
