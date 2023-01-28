<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Adjustment;
use App\Models\AdjustmentProduct;
use App\Models\Product;
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
                    'id'            => $adj->id,
                    'title'         => $adj->title,
                    'count'         => $adj->products->count(),
                    'done'          => $adj->products->whereNotNull('status')->count(),
                    'not_done'      => $adj->products->whereNull('status')->count(),
                    'status'        => $adj->status
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

    public function edit(Request $request, Adjustment $stock)
    {
        $adjustment = $stock->load('products');

        $products = AdjustmentProduct::query()
            ->where('adjustment_id', $adjustment->id)->with(['product.unit', 'product.category'])
            ->when($request->search, function ($query) use ($request) {
                $query
                    ->whereRelation('product', 'name', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('product', 'barcode', 'like', '%'.$request->search.'%');
            })
            ->paginate(10)
            ->withQueryString()
            ->through(function ($product) {
                $item = $product->product;
                return [
                    'id'            => $product->id,
                    'barcode'       => $item->barcode,
                    'name'          => $item->name,
                    'stock'         => [
                        'warehouse' => $item->warehouse_stock,
                        'store'     => $item->store_stock,
                        'total'     => ($item->warehouse_stock ?? 0) + ($item->store_stock ?? 0),
                        'adjust'    => $product->adjustment_stock,
                        'ending'    => $product->ending_stock,
                    ],
                    'unit'          => $item->unit ? $item->unit->name : null,
                    'category'      => $item->category ? $item->category->name : null,
                    'status'        => $product->status ? $product->status->format('d-m-Y H:i:s') : null,
                    'created_by'    => $item->user ? $item->user->name : null,
                    'created_at'    => $item->created_at->format('d-m-Y'),
                ];
            });

        return inertia('App/Management/Stock/StockEdit', [
            'adjustment'    => $adjustment,
            'products'      => $products
        ]);
    }
    public function update(Request $request, AdjustmentProduct $stock)
    {
        /**
         * 1. Update stock toko pada table product / Product::class sesuai dengan ending_stock pada table adjustment_product / AdjustmentProduct::class
         * 2. Udate stock pada table product_stock / ProductStock::class sesuai dengan ending_stock pada table adjustment_product_details / AdjustmentProductDetail::class
         * 3. Update status pada table adjustment_product / AdjustmentProduct::class sesuai dengan tanggal dan waktu saat ini
         */

        $stock->load(['product', 'details']);
        $product = $stock->product;
        return $product;
    }

    public function destroy(Request $request, AdjustmentProduct $stock)
    {
        $product = $stock->product;
        $current_stock = ($product->warehouse_stock ?? 0) + ($product->store_stock >> 0);
        DB::beginTransaction();
        try {
            $stock->update([
                'opening_stock'     => $current_stock,
                'adjustment_stock'  => 0,
                'ending_stock'      => $current_stock,
                'status'            => now(),
            ]);

            $stock->details()->delete();

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
