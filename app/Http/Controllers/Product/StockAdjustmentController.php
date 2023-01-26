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

        $products = $adjustment->products()->with(['product.unit', 'product.category','product' => function($builder) use ($request) {
            $builder->when($request->search, function ($query) use ($request){
                $query->where('name', 'like', '%'.$request->search);
            });
        }])->paginate(10)
            ->withQueryString()
            ->through(function ($product) {
                $item = $product->product;
                return [
                    'id' => $product->id,
                    'barcode' => $item->barcode,
                    'name' => $item->name,
                    'stock' => [
                        'warehouse' => $item->warehouse_stock,
                        'store'     => $item->store_stock,
                        'total'     => $item->warehouse_stock ?? 0 + $item->store_stock ?? 0
                    ],
                    'unit' => $item->unit ? $item->unit->name : null,
                    'category' => $item->category ? $item->category->name : null,
                    'created_by' => $item->user ? $item->user->name : null,
                    'created_at' => $item->created_at->format('d-m-Y'),
                ];
            });

        return inertia('App/Management/Stock/StockEdit', [
            'adjustment'    => $adjustment,
            'products'      => $products
        ]);
    }

    public function delete(Request $request, AdjustmentProduct $stock)
    {
        dd($stock);
    }
}
