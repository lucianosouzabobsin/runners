<?php

namespace App\Rules;

use App\Competition;
use Illuminate\Contracts\Validation\Rule;

class TypeInTypes implements Rule
{
    private $typesBase;
    private $messageErrorTypes;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $this->typesBase = Competition::getTypes();

        $types = [];
        foreach ($this->typesBase as $type) {
            array_push($types, $type['type']);
        }

        $this->messageErrorTypes = implode(' or ', $types);

        return in_array($value, $types);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Must be '.$this->messageErrorTypes.'.';
    }
}
