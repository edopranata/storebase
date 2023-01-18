<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use App\Models\SellReturn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportRecapTransactionController extends Controller
{
    public function index(Request $request)
    {

        return inertia('App/Report/ReportRecapTransaction', [

        ]);

    }
}
