<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentProduct;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjustmentProductDetailController extends Controller
{
    public function index()
    {
        return to_route('app.management.stock.index');
    }

    public function show(Request $request, AdjustmentProduct $detail)
    {

        $details = $detail->load(['stocks', 'product.unit', 'adjustment', 'details'])->loadSum('stocks', 'available_stock');
        $stock = $details->details;

        $stocks = $details->stocks()
            ->whereNotIn('id', $stock->pluck('product_stock_id'))
            ->with(['product.unit', 'supplier'])
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $adjustment_left = $detail->adjustment->products()->whereNull('status')->count();

        return inertia('App/Management/Details/DetailsEdit', [
            'details'   => $details,
            'stocks'    => $stocks,
            'adj_left'  => $adjustment_left,
        ]);
    }

    public function update(Request $request, AdjustmentProduct $detail)
    {
        $stock = ProductStock::find($request->stock_id);

        $request->validate([
            'ending_stock'  => ['required', 'numeric', 'max:'. $stock->first_stock, 'min:'. 0]
        ]);
        $ending_stock = ProductStock::query()->where('product_id', $detail->product_id)->sum('available_stock');

        DB::beginTransaction();
        try {
            $detail->update([
                'opening_stock'     => $ending_stock
            ]);
            $detail->increment('adjustment_stock', $request->adjustment_stock);
            $detail->increment('ending_stock', $request->ending_stock);

            $detail->details()->create([
                'product_stock_id'  => $request->stock_id,
                'opening_stock'     => $stock->available_stock,
                'adjustment_stock'  => $request->adjustment_stock,
                'ending_stock'      => $request->ending_stock,
            ]);

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
