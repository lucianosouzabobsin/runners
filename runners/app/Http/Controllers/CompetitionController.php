<?php

namespace App\Http\Controllers;

use App\Rules\CompetitionNotRegistered;
use App\Rules\TypeInTypes;
use App\Services\ServiceCompetition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompetitionController extends Controller
{
    protected $competitionService;

    public function __construct(ServiceCompetition $competitionService)
    {
        $this->competitionService = $competitionService;
    }

    public function index()
    {
        return $this->competitionService->getAll();
    }

    public function store(Request $request)
    {
        try {
            $inputs = $request->all();
            $inputs['competition'] = '0';

            $validator = Validator::make($inputs, [
                'type' => ['required', new TypeInTypes($this->competitionService)],
                'date' => ['required', 'date_format:"Y-m-d"'],
                'hour_init' => ['required', 'date_format:"H:i:s"'],
                'min_age' => ['required', 'numeric', 'min:18'],
                'max_age' => ['required', 'numeric', 'gt:min_age'],
                'competition' => ['required', new CompetitionNotRegistered($request->all(), $this->competitionService)]
            ]);

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ], 404);
            }

            $competition = $this->competitionService->make($request->all());

            return response()->json($competition, 201);
        } catch (\Throwable $th) {
            $error = 'Bad request';

            return response()->json([
                'error' =>  $error
            ], 404);
        }
    }
}
