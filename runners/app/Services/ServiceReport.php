<?php

namespace App\Services;

class ServiceReport
{
    public function __construct()
    {

    }

    public function getRequestToParams($inputs)
    {
        $params = [];
        if (isset($inputs['range_age'])) {
            $params['min_age'] = $inputs['range_age'][0];
            $params['max_age'] = $inputs['range_age'][1];
        }

        if (isset($inputs['competition'])) {
            $params['competition_id'] = $inputs['competition'];

            if ($params['competition_id'] == '0') {
                unset($params['competition_id']);
            }
        }

        if (isset($inputs['type'])) {
            $params['type'] = $inputs['type'];
        }

        return $params;
    }
}
