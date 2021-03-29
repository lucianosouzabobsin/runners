<?php

namespace App\Http\Controllers;

use App\Rules\AgeGreaterThanEighteen;
use App\Runner;
use App\Services\ServiceRunner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RunnerController extends Controller
{
    protected $runnerService;

    public function __construct(ServiceRunner $runnerService)
    {
        $this->runnerService = $runnerService;
    }

    public function index()
    {
        return $this->runnerService->getAll();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'cpf' => ['required', 'numeric'],
                'birthday' => ['required', 'date_format:"Y-m-d"', new AgeGreaterThanEighteen],
            ]);

            if ($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()->toArray()
                ], 404);
            }

            $runner = $this->runnerService->make($request->all());
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
