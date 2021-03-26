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

            $runnerCompetition = RunnerCompetition::create($request->all());

            return response()->json($runnerCompetition, 201);
        } catch (\Throwable $th) {
            $error = $th->getMessage();

            return response()->json([
                'error' => $error
            ], 404);
        }
    }
}
