<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Providers\CompetitionServiceProvider;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        return Competition::all();
    }

    public function store(Request $request)
    {
        try {
            $provider = new CompetitionServiceProvider($request->all());
            $validator = $provider->validateFields();

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
