<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{
    protected $fillable = [
        'name',
        'cpf',
        'birthday'
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
