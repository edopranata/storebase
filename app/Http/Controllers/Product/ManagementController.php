<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementController extends Controller
{

    public function index()
    {
        return inertia('App/Management/ManagementIndex');
    }
}
