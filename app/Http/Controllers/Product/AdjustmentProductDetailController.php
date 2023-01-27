<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentProduct;
use Illuminate\Http\Request;

class AdjustmentProductDetailController extends Controller
{

    public function index()
    {
        return to_route('app.management.stock.index');
    }

    public function show(Request $request, AdjustmentProduct $detail)
    {
        dd($detail->load(['stocks', 'product'])->loadSum('stocks', 'available_stock'));
    }
}
