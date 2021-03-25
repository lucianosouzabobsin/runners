<?php

namespace App\Http\Controllers;

use App\Runner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RunnerController extends Controller
{
    private $ageAvaliable = false;

    public function index()
    {
        return Runner::all();
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validateFields($request);

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ], 404);
            }

            $runner = Runner::create($request->all());

            return response()->json($runner, 201);
        } catch (\Throwable $th) {
            $error = 'Bad request';
            if(strpos($th->getMessage(), 'UNIQUE constraint failed: runners.cpf') ){
                $error = 'The cpf already registered.';
            }

            return response()->json([
                'error' => $error
            ], 404);
        }
    }

    private function validateFields($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'cpf' => ['required', 'numeric'],
            'birthday' => [
                'required',
                'date_format:"Y-m-d"'
            ],
        ]);

        $this->ageAvaliable = Runner::validateBirthday($request->all());

        $validator->after(function($validator) {
            if (!$this->ageAvaliable) {
                $validator->errors()->add('age', 'under 18 years of age.');
            }
        });

        return $validator;
    }
}
