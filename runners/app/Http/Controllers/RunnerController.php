<?php

namespace App\Http\Controllers;

use App\Providers\RunnerServiceProvider;
use App\Runner;
use Illuminate\Http\Request;

class RunnerController extends Controller
{
    public function index()
    {
        return Runner::all();
    }

    public function store(Request $request)
    {
        try {
            $provider = new RunnerServiceProvider($request->all());
            $validator = $provider->validateFields();

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ], 404);
            }

            $runner = Runner::create($request->all());
            return response()->json($runner, 201);
        } catch (\Throwable $th) {
            $error = 'Bad request';
            if(strpos($th->getMessage(), 'Integrity constraint violation') ){
                $error = 'The cpf already registered.';
            }

            return response()->json([
                'error' => $error
            ], 404);
        }
    }
}
