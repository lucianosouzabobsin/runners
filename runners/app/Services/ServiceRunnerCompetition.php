<?php

namespace App\Services;

use App\Repositories\Contracts\RunnerCompetitionRepositoryInterface;

class ServiceRunnerCompetition
{
    protected $runnerCompetitionRepository;
    private $currentCompetition = 0;
    private $currentType = 0;
    private $currentAge = 0;
    private $positionCompetition = 0;
    private $positionRangeAgeType = 0;
    private $positionRangeAge = 0;

    public function __construct(RunnerCompetitionRepositoryInterface $runnerCompetitionRepository)
    {
        $this->runnerCompetitionRepository = $runnerCompetitionRepository;
    }

    /**
     * Create runnerCompetition
     *
     * @return array
    */
    public function make(array $data)
    {
        return $this->runnerCompetitionRepository->make($data);
    }

    /**
     * Return runner with age
     *
     * @return array
    */
    public function canRunOnDate(int $runner_id, string $date)
    {
        return $this->runnerCompetitionRepository->canRunOnDate($runner_id, $date);
    }

    /**
     * Return runner with age
     *
     * @return array
    */
    public function getByAgeTypeTrial()
    {
        return $this->runnerCompetitionRepository->getByAgeTypeTrial();
    }

    /**
     * Return runner with age
     *
     * @return array
    */
    public function report(array $inputs)
    {
        return $this->runnerCompetitionRepository->report($inputs);
    }

    /**
     * Run the update positions.
     *
     *  @return void
     */
    public function updateAllPositions()
    {
        $runnerscompetitionsBase = $this->runnerCompetitionRepository->getByAgeTypeTrial();

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
        $runnerResult = $this->runnerCompetitionRepository->findOrFail($id);

        $runnerResult->position_competition = $this->positionCompetition;
        $runnerResult->position_range_age = $this->positionRangeAge;
        $runnerResult->position_range_age_type = $this->positionRangeAgeType;
        $runnerResult->save();
    }

    public function getRequestToParams($inputs)
    {
        $params = [];
        if (isset($inputs['range_age'])) {
            $params['min_age'] = $inputs['range_age'][0];
            $params['max_age'] = $inputs['range_age'][1];
        }

        if (isset($inputs['competition'])) {
            $params['competition_id'] = $inputs['competition'];
        }

        if (isset($inputs['type'])) {
            $params['type'] = $inputs['type'];
        }

        return $params;
    }
}
