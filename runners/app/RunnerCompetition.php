<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RunnerCompetition extends Model
{
    protected $fillable = [
        'runner_id',
        'competition_id',
        'hour_end',
        'position'
    ];

    protected $casts = [
        'hour_end' => 'datetime:H:i:s',
    ];
}
