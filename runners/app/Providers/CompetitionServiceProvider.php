<?php

namespace App\Providers;

use App\Competition;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rule;

class CompetitionServiceProvider extends ServiceProvider
{
    private $validator;
    private $request;
    private $alltypes = ['3', '5', '10', '21', '42'];
    private $existsCompetition = false;

    /**
     * Create a new service provider instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        $this->request = $inputs;
        $this->validator = Validator::make($inputs, [
            'type' => ['required', Rule::in($this->alltypes)],
            'date' => ['required', 'date_format:"Y-m-d"'],
            'hour_init' => ['required', 'date_format:"H:i:s"'],
            'min_age' => ['required', 'numeric', 'min:18'],
            'max_age' => ['required', 'numeric', 'gt:min_age'],
        ]);

    }

    /**
     * Run the validator fields.
     *
     *  @return \Validator
     */
    public function validateFields()
    {
        $this->existsCompetition = Competition::existCompetition($this->request);

        $this->validator->after(function($validator) {
            if ($this->existsCompetition) {
                $validator->errors()->add('competition', 'Already registered.');
            }
        });

        return $this->validator;
    }
}
