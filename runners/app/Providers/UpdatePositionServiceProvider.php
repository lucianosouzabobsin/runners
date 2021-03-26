<?php

namespace App\Providers;

use App\Competition;
use App\RunnerCompetition;
use Illuminate\Support\ServiceProvider;

class UpdatePositionServiceProvider extends ServiceProvider
{
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
        $this->updatePositionsCompetitions();
        $this->updatePositionsRangeAgeAndType();
    }

    private function updatePositionsCompetitions()
    {
        $competitionsBase = Competition::getCompetitions();

        foreach ($competitionsBase as $competition) {
            $runnerscompetitionsBase = RunnerCompetition::getByCompetition($competition['id']);
            $this->updatePositionsByCompetitions($runnerscompetitionsBase);
        }
    }

    private function updatePositionsByCompetitions($runnerscompetitionsBase)
    {
        $position = 1;
        foreach ($runnerscompetitionsBase as $competition) {
            $runnerResult = RunnerCompetition::findOrFail($competition['id']);
            $runnerResult->position_competition = $position;
            $runnerResult->save();

            $position++;
        }
    }

    private function updatePositionsRangeAgeAndType()
    {
        $runnerscompetitionsBase = RunnerCompetition::getByRangeAgeAndType();

        $currentType = 0;
        $currentAge = 0;
        $positionRangeAgeType = 0;
        $positionRangeAge = 0;
        foreach ($runnerscompetitionsBase as $competition) {

            if ($competition['type'] != $currentType) {
                $positionRangeAgeType = 1;
                $currentType = $competition['type'];
            }

            if ($competition['min_age'] != $currentAge) {
                $positionRangeAge = 1;
                $currentAge = $competition['min_age'];
            }

            $runnerResult = RunnerCompetition::findOrFail($competition['id']);

            $runnerResult->position_range_age = $positionRangeAge;
            $runnerResult->position_range_age_type = $positionRangeAgeType;
            $runnerResult->save();

            $positionRangeAge++;
            $positionRangeAgeType++;
        }
    }
}
