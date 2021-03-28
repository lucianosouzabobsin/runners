<?php

namespace App\Providers;

use App\Competition;
use App\Runner;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class RunnerCompetitionServiceProvider extends ServiceProvider
{
    private $request;
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
        $this->run();
    }

    /**
     * Run the validator fields to Runner.
     *
     *  @return void
     */
    public function run()
    {
        $runner = Runner::getWithAge($this->request['runner_id']);
        $competition = Competition::where('id', $this->request['competition_id'])->get()->toArray();

        $this->runnerAge = $runner['age'];

        $this->setTimeCompetition(
            $competition[0]['hour_init'],
            $this->request['hour_end']
        );
    }

    public function setTimeCompetition($hour_init, $hour_end)
    {
        $init = Carbon::createFromFormat('H:i:s', $hour_init);
        $end = Carbon::createFromFormat('H:i:s', $hour_end);

        $difference = $init->diff($end)->format('%H:%I:%S');

        $this->timeCompetition = $difference;
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
