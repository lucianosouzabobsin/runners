<?php

namespace App\Http\Controllers;

use App\Providers\ReportServiceProvider;
use App\Providers\UpdatePositionServiceProvider;
use App\RunnerCompetition;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return RunnerCompetition::all();
    }

    public function list(Request $request)
    {
        $provider = new ReportServiceProvider($request->all());
        $validator = $provider->validateFields();

        if ($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()->toArray()
            ], 404);
        }

        $updaterProvider = new UpdatePositionServiceProvider();
        $updaterProvider->run();

        $inputs = $provider->getRequestToParams();

        return RunnerCompetition::report($inputs);
    }
}
