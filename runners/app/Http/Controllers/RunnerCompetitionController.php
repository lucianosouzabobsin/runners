<?php

namespace App\Http\Controllers;

use App\RunnerCompetition;
use Illuminate\Http\Request;

class RunnerCompetitionController extends Controller
{
    public function index()
    {
        return RunnerCompetition::all();
    }
}
