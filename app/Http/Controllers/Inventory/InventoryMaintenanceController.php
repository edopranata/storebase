<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryMaintenanceController extends Controller
{

    public function index()
    {

        return inertia('App/Inventory/InventoryMaintenance');
    }
}
