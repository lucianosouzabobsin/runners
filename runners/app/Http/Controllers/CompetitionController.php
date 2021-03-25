<?php

namespace App\Http\Controllers;

use App\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompetitionController extends Controller
{
    private $alltypes = ['3', '5', '10', '21', '42'];
    private $existsCompetition = false;

    public function index()
    {
        return Competition::all();
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validateFields($request);

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ], 404);
            }

            $competition = Competition::create($request->all());

            return response()->json($competition, 201);
        } catch (\Throwable $th) {
            $error = 'Bad request';

            return response()->json([
                'error' => $error
            ], 404);
        }
    }

    /**
     * Run the validator fields to Runner.
     *
     *  @return \Validator
     */
    private function validateFields($request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', Rule::in($this->alltypes)],
            'date' => ['required', 'date_format:"Y-m-d"'],
            'hour_init' => ['required', 'date_format:"H:i:s"'],
            'min_age' => ['required', 'numeric', 'min:18'],
            'max_age' => ['required', 'numeric', 'gt:min_age'],
        ]);

        $this->existsCompetition = Competition::exitsCompetition($request->all());

        $validator->after(function($validator) {
            if ($this->existsCompetition) {
                $validator->errors()->add('competition', 'Already registered.');
            }
        });

        return $validator;
    }
}
