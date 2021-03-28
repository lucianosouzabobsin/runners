<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('login', 'Auth\LoginController@login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('add.runner', 'RunnerController@store');
    Route::post('add.competition', 'CompetitionController@store');
    Route::get('list.runner', 'RunnerController@index');
    Route::get('list.competition', 'CompetitionController@index');
    Route::post('add.runner.competition', 'RunnerCompetitionController@store');
    Route::post('report.get.list', 'ReportController@list');
});

