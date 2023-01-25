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
            ->withCount('products')
            ->with('products')->get();
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
                ->chunk(100, function ($chunk_product) use ($adjustment) {
                    dd($chunk_product);
//                    $adjustment->products()->createMany($chunk_product);
                });
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
