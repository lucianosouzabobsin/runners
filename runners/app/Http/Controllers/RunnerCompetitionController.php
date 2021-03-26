<?php

namespace App\Http\Controllers;

use App\Providers\RunnerCompetitionServiceProvider;
use App\RunnerCompetition;
use Illuminate\Http\Request;

class RunnerCompetitionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $provider = new RunnerCompetitionServiceProvider($request->all());
            $validator = $provider->validateFields();

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ], 404);
            }

            $inputs = $request->all();

            $inputs['runner_age'] = $provider->getRunnerAge();
            $inputs['trial_time'] = $provider->getTimeCompetition();

            $runnerCompetition = RunnerCompetition::create($inputs);

            return response()->json($runnerCompetition, 201);
        } catch (\Throwable $th) {
            $error = 'Bad request';

            return response()->json([
                'error' => $error
            ], 404);
        }
    }
}
