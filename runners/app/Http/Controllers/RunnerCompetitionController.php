<?php

namespace App\Http\Controllers;

use App\Rules\AgeAllowed;
use App\Rules\CanRunOnDate;
use App\Rules\CompetitionExists;
use App\Rules\EndTimeNotEqualsToStart;
use App\Rules\RunnerExists;
use App\Services\ServiceCompetition;
use App\Services\ServiceRunner;
use App\Services\ServiceRunnerCompetition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RunnerCompetitionController extends Controller
{
    protected $runnerCompetitionService;
    protected $runnerService;
    protected $competitionService;

    public function __construct(
        ServiceRunnerCompetition $runnerCompetitionService,
        ServiceRunner $runnerService,
        ServiceCompetition $competitionService)
    {
        $this->runnerCompetitionService = $runnerCompetitionService;
        $this->runnerService = $runnerService;
        $this->competitionService = $competitionService;
    }

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
                'runner' => [
                    'required',
                    new RunnerExists(
                        $request->all(),
                        $this->runnerService
                    )],
                'competition' => [
                    'required',
                    new CompetitionExists(
                        $inputs['competition_id'],
                        $this->competitionService)
                    ],
                'age' => [
                    'required',
                    new AgeAllowed(
                        $request->all(),
                        $this->runnerService,
                        $this->competitionService
                    )],
                'date' => [
                    'required',
                    new CanRunOnDate(
                        $request->all(),
                        $this->runnerService,
                        $this->competitionService,
                        $this->runnerCompetitionService
                    )],
                'hour' => [
                    'required',
                    new EndTimeNotEqualsToStart(
                        $request->all(),
                        $this->runnerService,
                        $this->competitionService
                    )],
            ]);

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ], 404);
            }

            $inputs = $request->all();
            $inputs['runner_age'] = $this->runnerService->getRunnerAge($inputs['runner_id']);
            $inputs['trial_time'] = $this->competitionService->getTimeCompetition(
                $inputs['competition_id'],
                $inputs['hour_end']
            );

            $runnerCompetition = $this->runnerCompetitionService->make($inputs);

            return response()->json($runnerCompetition, 201);
        } catch (\Throwable $th) {
            $error = 'Bad request';

            return response()->json([
                'error' => $th->getMessage()
            ], 404);
        }
    }
}
