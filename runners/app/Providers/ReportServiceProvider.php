<?php

namespace App\Providers;

use App\Competition;
use App\RunnerCompetition;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    private $validator;
    private $request;
    private $rangeAgeAvaliable = true;
    private $rangesAgesBase;
    private $messageErrorRangeAge;
    private $typesBase;
    private $messageErrorTypes;
    private $typeAvaliable = true;

    /**
     * Create a new service provider instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        if (isset($inputs['range_age'])) {
            $inputs['range_age'] = explode(",", $inputs['range_age']);
        }

        $this->request = $inputs;
        $this->validator = Validator::make($inputs, [
            'range_age' => ['array','min:2','max:2'],
            'range_age.*' => ['string','distinct'],
            'competition' => ['numeric'],
            'type' => ['numeric'],
        ]);
    }

    /**
     * Run the validator fields to Runner.
     *
     *  @return \Validator
     */
    public function validateFields()
    {
        $this->rangesAgesBase = Competition::getRangeAges();
        $this->typesBase = Competition::getTypes();
        $this->validateRangeAge();
        $this->validateCompetition();
        $this->validateType();

        $this->validator->after(function($validator) {
            if (!$this->rangeAgeAvaliable) {
                $validator->errors()->add('range_age', 'range must be'.$this->messageErrorRangeAge.'.');
            }

            if (!$this->typeAvaliable) {
                $validator->errors()->add('type', 'types must be '.$this->messageErrorTypes.'.');
            }
        });

        return $this->validator;
    }

    private function validateRangeAge()
    {
        if (isset($this->request['range_age'])) {
            $this->rangeAgeAvaliable = false;
            $min_age = trim($this->request['range_age'][0]);
            $max_age = trim($this->request['range_age'][1]);

            foreach ($this->rangesAgesBase as $range) {
                $this->messageErrorRangeAge .= sprintf(' %d,%d or',$range['min_age'], $range['max_age']);

                if ($range['min_age'] == $min_age && $range['max_age'] == $max_age) {
                    $this->rangeAgeAvaliable = true;
                }
            }

            $this->messageErrorRangeAge = substr($this->messageErrorRangeAge, 0, -3);
        }
    }

    private function validateCompetition()
    {
        if (isset($this->request['competition'])) {
            $competition = Competition::where('id', $this->request['competition'])
                ->get()
                ->toArray();

            if (empty($competition)) {
                $this->validator->after(function($validator) {
                    $validator->errors()->add('competition', 'Competition not exists.');
                });
            }
        }
    }

    private function validateType()
    {
        if (isset($this->request['type'])) {
            $types = [];
            foreach ($this->typesBase as $type) {
                array_push($types, $type['type']);
            }

            if (!in_array($this->request['type'], $types)) {
                $this->typeAvaliable = false;
            }

            $this->messageErrorTypes = implode(' or ', $types);
        }
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
