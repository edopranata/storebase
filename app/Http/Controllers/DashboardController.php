<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        return inertia('Dashboard/DashboardIndex');
    }

    public function blank()
    {
        return inertia('Blank/BlankIndex');
    }
}
