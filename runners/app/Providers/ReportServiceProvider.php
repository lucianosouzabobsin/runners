<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    private $request;

    /**
     * Create a new service provider instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        $this->request = $inputs;
    }

    public function getRequestToParams()
    {
        $inputs = $this->request;
        $params = [];

        if (isset($inputs['range_age'])) {
            $params['min_age'] = $inputs['range_age'][0];
            $params['max_age'] = $inputs['range_age'][1];
        }

        if (isset($inputs['competition'])) {
            $params['competition_id'] = $inputs['competition'];
        }

        if (isset($inputs['type'])) {
            $params['type'] = $inputs['type'];
        }

        return $params;

    }
}
