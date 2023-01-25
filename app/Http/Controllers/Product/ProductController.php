<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['user', 'category', 'unit'])
            ->filter($request->search)
            ->paginate(20)
            ->withQueryString()
            ->through(function ($products) {
                return [
                    'id' => $products->id,
                    'barcode' => $products->barcode,
                    'name' => $products->name,
                    'description' => $products->description,
                    'stock' => [
                        'warehouse' => $products->warehouse_stock,
                        'store'     => $products->store_stock
                    ],
                    'unit' => $products->unit ? $products->unit->name : null,
                    'category' => $products->category ? $products->category->name : null,
                    'created_by' => $products->user ? $products->user->name : null,
                    'created_at' => $products->created_at->format('d-m-Y'),
                ];
            });

        return inertia('App/Management/Product/ProductIndex', compact('products'));
    }
}
