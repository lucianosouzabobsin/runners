<?php

namespace App\Http\Controllers;

use App\Rules\CompetitionExists;
use App\Rules\RangeAgeAvaliable;
use App\Rules\TypeInTypes;
use App\Services\ServiceCompetition;
use App\Services\ServiceReport;
use App\Services\ServiceRunner;
use App\Services\ServiceRunnerCompetition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    protected $runnerCompetitionService;
    protected $runnerService;
    protected $competitionService;
    protected $reportService;

    public function __construct(
        ServiceRunnerCompetition $runnerCompetitionService,
        ServiceRunner $runnerService,
        ServiceCompetition $competitionService,
        ServiceReport $reportService)
    {
        $this->runnerCompetitionService = $runnerCompetitionService;
        $this->runnerService = $runnerService;
        $this->competitionService = $competitionService;
        $this->reportService = $reportService;
    }

    public function list(Request $request)
    {
        $inputs = $request->all();
        if (isset($inputs['range_age'])) {
            $inputs['range_age'] = explode(",", $inputs['range_age']);
        }

        if (!isset($inputs['competition'])) {
            $inputs['competition'] = '0';
        }

        $validator = Validator::make($inputs, [
            'range_age' => [
                'array',
                'min:2','max:2',
                new RangeAgeAvaliable($this->competitionService)
            ],
            'range_age.*' => ['string','distinct'],
            'competition' => [
                'numeric',
                new CompetitionExists(
                    $inputs['competition'],
                    $this->competitionService
                )],
            'type' => ['numeric', new TypeInTypes($this->competitionService)],
        ]);

        if ($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()->toArray()
            ], 404);
        }

        $this->runnerCompetitionService->updateAllPositions();
        $inputs = $this->reportService->getRequestToParams($inputs);

        return $this->runnerCompetitionService->report($inputs);
    }
}
