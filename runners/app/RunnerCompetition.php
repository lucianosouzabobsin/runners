<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RunnerCompetition extends Model
{
    protected $fillable = [
        'runner_id',
        'competition_id',
        'hour_end'
    ];

    protected $casts = [
        'hour_end' => 'datetime:H:i:s',
    ];

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
}
