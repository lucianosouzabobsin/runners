<?php

namespace App\Rules;

use App\Services\ServiceCompetition;
use Illuminate\Contracts\Validation\Rule;

class CompetitionExists implements Rule
{
    protected $competitionId;
    protected $serviceCompetition;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id, ServiceCompetition $serviceCompetition)
    {
        $this->competitionId = $id;
        $this->serviceCompetition = $serviceCompetition;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this->competitionId == '0'){
            return true;
        }

        $competition = $this->serviceCompetition->getCompetition($this->competitionId);
        return !empty($competition);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Competition not exists.';
    }
}
