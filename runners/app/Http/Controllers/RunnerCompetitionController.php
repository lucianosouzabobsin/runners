<?php

namespace App\Http\Controllers;

use App\Providers\RunnerCompetitionServiceProvider;
use App\Rules\AgeAllowed;
use App\Rules\CanRunOnDate;
use App\Rules\CompetitionExists;
use App\Rules\EndTimeNotEqualsToStart;
use App\Rules\RunnerExists;
use App\RunnerCompetition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RunnerCompetitionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $inputs = $request->all();
            $inputs['runner'] = 'null';
            $inputs['competition'] = 'null';
            $inputs['age'] = 'null';
            $inputs['date'] = 'null';
            $inputs['hour'] = 'null';

            $validator = Validator::make($inputs, [
                'runner_id' => ['required'],
                'competition_id' => ['required'],
                'hour_end' => ['required', 'date_format:"H:i:s"'],
                'runner' => ['required', new RunnerExists($request->all())],
                'competition' => ['required', new CompetitionExists($inputs['competition_id'])],
                'age' => ['required', new AgeAllowed($request->all())],
                'date' => ['required', new CanRunOnDate($request->all())],
                'hour' => ['required', new EndTimeNotEqualsToStart($request->all())],
            ]);

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ], 404);
            }
            $provider = new RunnerCompetitionServiceProvider($request->all());

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
