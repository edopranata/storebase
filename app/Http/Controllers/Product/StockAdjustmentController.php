<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Adjustment;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{

    public function index()
    {
        $adjustments = Adjustment::query()

            ->with('products')
            ->paginate(3)
            ->withQueryString()
            ->through(function ($adj) {
                return [
                    'title'         => $adj->title,
                    'count'         => $adj->products->count(),
                    'done'          => $adj->products->whereNotNull('status')->count(),
                    'not_done'      => $adj->products->whereNull('status')->count()
                ];
            });
        return inertia('App/Management/Stock/StockIndex', compact('adjustments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'min:8']
        ]);

        DB::beginTransaction();
        try {
            $adjustment = Adjustment::query()
                ->with('products')
                ->create([
                    'title' => $request->name
                ]);
            $product = Product::query()
                ->select(['id'])
                ->get()->map(function ($pr) {
                    return [
                        'product_id' => $pr->id
                    ];
                });
//            dd($product->toArray());
            $adjustment->products()->createMany($product);

            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data berhasil disimpan"
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data gagal disimpan: " . $exception->getMessage()
            ]);
        }


    }
}
