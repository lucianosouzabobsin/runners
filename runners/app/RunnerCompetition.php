<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RunnerCompetition extends Model
{
    protected $fillable = [
        'runner_id',
        'competition_id',
        'runner_age',
        'hour_end',
        'trial_time',
    ];

    protected $casts = [
        'hour_end' => 'datetime:H:i:s',
        'trial_time' => 'datetime:H:i:s',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    static public function canRunOnDate($runner_id, $date)
    {
        $ran = RunnerCompetition::select('*')
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

    static public function getByCompetition($competition)
    {
        return RunnerCompetition::select('*')
        ->where('competition_id', $competition)
        ->orderBy('trial_time', 'ASC')
        ->get()
        ->toArray();
    }

    static public function getByRangeAgeAndType()
    {
        return RunnerCompetition::select('runner_competitions.id',
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

    static public function report($inputs)
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
}
