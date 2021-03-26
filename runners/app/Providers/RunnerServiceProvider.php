<?php

namespace App\Providers;

use App\Runner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class RunnerServiceProvider extends ServiceProvider
{
    private $validator;
    private $request;
    private $ageAvaliable = false;

    /**
     * Create a new service provider instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        $this->request = $inputs;
        $this->validator = Validator::make($inputs, [
            'name' => ['required'],
            'cpf' => ['required', 'numeric'],
            'birthday' => ['required', 'date_format:"Y-m-d"'],
        ]);
    }

    /**
     * Run the validator fields to Runner.
     *
     *  @return \Validator
     */
    public function validateFields()
    {
        $this->ageAvaliable = $this->validateBirthday($this->request);

        $this->validator->after(function($validator) {
            if (!$this->ageAvaliable) {
                $validator->errors()->add('age', 'under 18 years of age.');
            }
        });

        return $this->validator;
    }

    public function validateBirthday($data)
    {
        $date = Carbon::createFromFormat('Y-m-d', $data['birthday']);
        $age = $date->diffInYears(Carbon::now());

        if($age >= 18) {
            return true;
        }

        return false;
    }
}
