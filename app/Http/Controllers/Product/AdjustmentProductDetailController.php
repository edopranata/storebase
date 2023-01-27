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
        $details = $detail->load(['stocks', 'product.unit', 'adjustment'])->loadSum('stocks', 'available_stock');
        $stocks = $details->stocks()
            ->with(['product.unit', 'supplier'])
            ->paginate(10)
            ->withQueryString();

//        dd($stocks);
        return inertia('App/Management/Details/DetailsEdit', [
            'details'   => $details,
            'stocks'    => $stocks,
        ]);
    }
}
