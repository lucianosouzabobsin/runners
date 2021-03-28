<?php

namespace App\Http\Controllers;

use App\Providers\ReportServiceProvider;
use App\Providers\UpdatePositionServiceProvider;
use App\Rules\CompetitionExists;
use App\Rules\RangeAgeAvaliable;
use App\Rules\TypeInTypes;
use App\RunnerCompetition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index()
    {
        return RunnerCompetition::all();
    }

    public function list(Request $request)
    {
        $inputs = $request->all();
        if (isset($inputs['range_age'])) {
            $inputs['range_age'] = explode(",", $inputs['range_age']);
        }

        $validator = Validator::make($inputs, [
            'range_age' => ['array','min:2','max:2',new RangeAgeAvaliable],
            'range_age.*' => ['string','distinct'],
            'competition' => ['numeric', new CompetitionExists($inputs['competition'])],
            'type' => ['numeric', new TypeInTypes],
        ]);

        if ($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()->toArray()
            ], 404);
        }

        $updaterServiceProvider = new UpdatePositionServiceProvider();
        $updaterServiceProvider->run();

        $reportServiceProvider = new ReportServiceProvider($inputs);

        $inputs = $reportServiceProvider->getRequestToParams();

        return RunnerCompetition::report($inputs);
    }
}
