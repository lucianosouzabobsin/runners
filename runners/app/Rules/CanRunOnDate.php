<?php

namespace App\Rules;

use App\Competition;
use App\Runner;
use App\RunnerCompetition;
use Illuminate\Contracts\Validation\Rule;

class CanRunOnDate implements Rule
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
            return RunnerCompetition::canRunOnDate($runner['id'], $competition[0]['date']);
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
