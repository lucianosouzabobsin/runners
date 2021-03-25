<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = [
        'type',
        'date',
        'hour_init',
        'min_age',
        'max_age'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'hour_init' => 'date:H:i:s',
    ];
}
