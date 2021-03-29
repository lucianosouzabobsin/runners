<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
