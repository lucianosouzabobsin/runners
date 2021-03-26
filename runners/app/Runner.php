<?php

namespace App;

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

    static public function getWithAge($id)
    {
        $runner = Runner::select('*')->
        selectRaw("TIMESTAMPDIFF (YEAR, birthday,CURDATE()) as age")
        ->where('id', $id)
        ->get()
        ->toArray();

        if(!empty($runner)){
            return $runner[0];
        }

        return $runner;
    }
}
