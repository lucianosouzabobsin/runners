<?php

namespace App\Providers;

use App\Competition;
use App\RunnerCompetition;
use Illuminate\Support\ServiceProvider;

class UpdatePositionServiceProvider extends ServiceProvider
{
    private $currentCompetition = 0;
    private $currentType = 0;
    private $currentAge = 0;
    private $positionCompetition = 0;
    private $positionRangeAgeType = 0;
    private $positionRangeAge = 0;

    /**
     * Create a new service provider instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Run the update positions.
     *
     *  @return void
     */
    public function run()
    {
        $runnerscompetitionsBase = RunnerCompetition::getByAgeTypeTrial();

        foreach ($runnerscompetitionsBase as $competition) {
            $this->resetVariableControl($competition);
            $this->updatePositions($competition['id']);
            $this->incrementVariablesPositions();
        }
    }

    private function resetVariableControl($competition)
    {
        if ($competition['type'] != $this->currentType) {
            $this->positionRangeAgeType = 1;
            $this->currentType = $competition['type'];
        }

        if ($competition['min_age'] != $this->currentAge) {
            $this->positionRangeAge = 1;
            $this->currentAge = $competition['min_age'];
        }

        if ($competition['competition_id'] != $this->currentCompetition) {
            $this->positionCompetition = 1;
            $this->currentCompetition = $competition['competition_id'];
        }
    }

    private function incrementVariablesPositions()
    {
        $this->positionCompetition++;
        $this->positionRangeAge++;
        $this->positionRangeAgeType++;
    }

    private function updatePositions($id)
    {
        $runnerResult = RunnerCompetition::findOrFail($id);

        $runnerResult->position_competition = $this->positionCompetition;
        $runnerResult->position_range_age = $this->positionRangeAge;
        $runnerResult->position_range_age_type = $this->positionRangeAgeType;
        $runnerResult->save();
    }
}
