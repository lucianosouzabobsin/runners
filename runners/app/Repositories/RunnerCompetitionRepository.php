<?php

namespace App\Repositories;

use App\Repositories\Contracts\RunnerCompetitionRepositoryInterface;
use App\Models\RunnerCompetition;
use Illuminate\Support\Facades\DB;

class RunnerCompetitionRepository implements RunnerCompetitionRepositoryInterface
{
    protected $entity;

    public function __construct(RunnerCompetition $runnerCompetition)
    {
        $this->entity = $runnerCompetition;
    }

    /**
     * Create runnerCompetition
     *
     * @return array
     */
    public function make(array $data)
    {
        return $this->entity->create($data);
    }


    /**
     * Verifiy exists competition
     *
     * @return array
     */
    public function canRunOnDate(int $runner_id, string $date)
    {
        $ran = $this->entity->select('*')
        ->join('competitions', 'competitions.id', '=', 'runner_competitions.competition_id')
        ->where('runner_id', $runner_id)
        ->where('date', $date." 00:00:00")
        ->get()
        ->toArray();

        if(!empty($ran)){
            return false;
        }

        return true;
    }

    public function getByAgeTypeTrial()
    {
        return $this->entity->select('runner_competitions.id',
        'runner_competitions.competition_id',
        'runner_competitions.trial_time',
        'competitions.type',
        'competitions.min_age',
        'competitions.max_age',
        'runner_competitions.position_competition',
        'runner_competitions.position_range_age',
        'runner_competitions.position_range_age_type')
        ->join('competitions', 'competitions.id', '=', 'runner_competitions.competition_id')
        ->orderBy('min_age', 'ASC')
        ->orderBy('type', 'ASC')
        ->orderBy('trial_time', 'ASC')
        ->get()
        ->toArray();
    }

    public function report(array $inputs)
    {
        return DB::table('runner_competitions')
        ->select('runner_competitions.competition_id',
        'competitions.type',
        'runner_competitions.runner_id',
        'competitions.min_age',
        'competitions.max_age',
        'runners.name',
        'runner_competitions.runner_age',
        'runner_competitions.trial_time',
        'runner_competitions.position_competition',
        'runner_competitions.position_range_age',
        'runner_competitions.position_range_age_type')
        ->join('competitions', 'competitions.id', '=', 'runner_competitions.competition_id')
        ->join('runners', 'runners.id', '=', 'runner_competitions.runner_id')
        ->where(function($query) use ($inputs) {
            if (isset($inputs['type'])) {
                $query->where('type', $inputs['type']);
            }

            if (isset($inputs['competition_id'])) {
                $query->where('competition_id', $inputs['competition_id']);
            }

            if(isset($inputs['min_age'])) {
                $query->where('min_age', $inputs['min_age']);
            }

            if(isset($inputs['max_age'])) {
                $query->where('max_age', $inputs['max_age']);
            }
        })
        ->orderBy('min_age', 'ASC')
        ->orderBy('type', 'ASC')
        ->orderBy('trial_time', 'ASC')
        ->get()
        ->toArray();
    }

    public function findOrFail($id)
    {
        return $this->entity->findOrFail($id);
    }
}
