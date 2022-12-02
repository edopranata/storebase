<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportIndexController extends Controller
{

    public function index()
    {
        return inertia('App/Report/ReportIndex');
    }
}
