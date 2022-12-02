<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportAssetController extends Controller
{

    public function index()
    {
//        dd(ProductStock::query()->selectRaw("sum(available_stock * buying_price) balance")->get());
        return inertia('App/Report/ReportAsset', [
            'position'  => now()->format('d F Y'),
            'total'     => ProductStock::query()->selectRaw("sum(available_stock * buying_price) balance")->first(),
            'assets'    => Product::query()->with(['category', 'unit'])->withCount([
                'stocks as total_asset' => function ($builder){
                $builder->select(DB::raw("SUM(available_stock * buying_price) as total"));
            }])->paginate()
        ]);
    }
}
