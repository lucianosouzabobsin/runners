<?php

namespace App\Rules;

use App\Competition;
use Illuminate\Contracts\Validation\Rule;

class CompetitionExists implements Rule
{
    private $competitionId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->competitionId = $id;
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
        $competition = Competition::where('id', $this->competitionId)->get()->toArray();
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
