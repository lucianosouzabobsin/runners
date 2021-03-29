<?php

namespace App\Rules;

use App\Services\ServiceRunner;
use Illuminate\Contracts\Validation\Rule;

class RunnerExists implements Rule
{
    protected $runnerService;
    protected $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request, ServiceRunner $runnerService)
    {
        $this->request = $request;
        $this->runnerService = $runnerService;
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
        $runner = $this->runnerService->getWithAge($this->request['runner_id']);
        return !empty($runner);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Runner not exists.';
    }
}
