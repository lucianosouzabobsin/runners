<?php

namespace App;

use Carbon\Carbon;
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

    static public function validateBirthday($data)
    {
        $date = Carbon::createFromFormat('Y-m-d', $data['birthday']);
        $age = $date->diffInYears(Carbon::now());

        if($age >= 18) {
            return true;
        }

        return false;
    }
}
