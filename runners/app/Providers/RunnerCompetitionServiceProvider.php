<?php

namespace App\Providers;

use App\Competition;
use App\Runner;
use App\RunnerCompetition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class RunnerCompetitionServiceProvider extends ServiceProvider
{
    private $validator;
    private $request;
    private $ableRunnerByDate = false;
    private $ableRunnerByHour = false;
    private $ableRunnerByAge = false;
    public $timeCompetition = "00:00:00";
    public $runnerAge = "0";

    /**
     * Create a new service provider instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        $this->request = $inputs;
        $this->validator = Validator::make($inputs, [
            'runner_id' => ['required'],
            'competition_id' => ['required'],
            'hour_end' => ['required', 'date_format:"H:i:s"'],
        ]);
    }

    /**
     * Run the validator fields to Runner.
     *
     *  @return \Validator
     */
    public function validateFields()
    {
        $runner = $this->validateRunner($this->request['runner_id']);
        $competition = $this->validateCompetition($this->request['competition_id']);

        $this->validateRunnerWithCompetition($runner, $competition);

        return $this->validator;
    }

    private function validateRunner($runner_id)
    {
        $runner = Runner::getWithAge($runner_id);

        if (empty($runner)) {
            $this->validator->after(function($validator) {
                $validator->errors()->add('runner', 'Runner not exists.');
            });
        }

        return $runner;
    }

    private function validateCompetition($competition_id)
    {
        $competition = Competition::where('id', $competition_id)->get()->toArray();

        if (empty($competition)) {
            $this->validator->after(function($validator) {
                $validator->errors()->add('competition', 'Competition not exists.');
            });
        }

        return $competition;
    }

    private function validateRunnerWithCompetition($runner, $competition)
    {
        if (!empty($runner) && !empty($competition)) {

            if (in_array($runner['age'], range($competition[0]['min_age'], $competition[0]['max_age']))) {
                $this->ableRunnerByAge = true;
                $this->runnerAge = $runner['age'];
            }

            $this->ableRunnerByDate = RunnerCompetition::canRunOnDate($runner['id'], $competition[0]['date']);

            $this->ableRunnerByHour = $this->validateHour(
                $competition[0]['hour_init'],
                $this->request['hour_end']
            );
        }

        $this->validator->after(function($validator) {
            if (!$this->ableRunnerByAge) {
                $validator->errors()->add('age', 'Age not allowed.');
            }

            if (!$this->ableRunnerByDate) {
                $validator->errors()->add('date', 'can not run on date.');
            }

            if (!$this->ableRunnerByHour) {
                $validator->errors()->add('hour', 'End time equal to start.');
            }
        });
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

        $this->timeCompetition = $difference;

        return true;
    }

    public function getRunnerAge()
    {
        return $this->runnerAge;
    }

    public function getTimeCompetition()
    {
        return $this->timeCompetition;
    }
}
