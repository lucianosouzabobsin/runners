<?php

namespace App\Rules;

use App\Services\ServiceCompetition;
use App\Services\ServiceRunner;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class EndTimeNotEqualsToStart implements Rule
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
            return $this->validateHour(
                $competition[0]['hour_init'],
                $this->request['hour_end']
            );
        }

        return true;
    }

    public function validateHour($hour_init, $hour_end)
    {
        $init = substr($hour_init, 0, 2);
        $end = substr($hour_end, 0, 2);

        $differenceHours = $end - $init;

        $init = Carbon::createFromFormat('H:i:s', $hour_init);
        $end = Carbon::createFromFormat('H:i:s', $hour_end);

        $difference = $init->diff($end)->format('%H:%I:%S');

        if ($difference == "00:00:00" || $differenceHours < 0) {
            return false;
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
        return 'End time less than or equal to Start time.';
    }
}
