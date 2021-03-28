<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Rules\CompetitionNotRegistered;
use App\Rules\TypeInTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompetitionController extends Controller
{
    public function index()
    {
        return Competition::all();
    }

    public function store(Request $request)
    {
        try {
            $inputs = $request->all();
            $inputs['competition'] = 'null';

            $validator = Validator::make($inputs, [
                'type' => ['required', new TypeInTypes],
                'date' => ['required', 'date_format:"Y-m-d"'],
                'hour_init' => ['required', 'date_format:"H:i:s"'],
                'min_age' => ['required', 'numeric', 'min:18'],
                'max_age' => ['required', 'numeric', 'gt:min_age'],
                'competition' => ['required', new CompetitionNotRegistered($request->all())]
            ]);

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
}
