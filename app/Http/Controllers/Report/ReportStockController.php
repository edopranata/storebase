<?php

namespace App\Http\Controllers\Report;

use App\Exports\Report\ProductStockExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Excel;
class ReportStockController extends Controller
{
    public function index(Request $request)
    {
        $product_name       = $request->product_name  ?: '';
        $category_id        = $request->category_id  ?: '';
        $per_pages          = $request->per_pages  ?: 15;

        return inertia('App/Report/ReportStock', [
            'product_name'  => $product_name,
            'category_id'   => $category_id,
            'per_pages'     => $per_pages,

            'categories'    => Category::query()->get()->map(function ($category){
                return [
                    'id'    => $category->id,
                    'text'  => $category->name
                ];
            }),
            'products'      => Product::query()
                ->with(['unit', 'stocks', 'prices' => function($price) {
                    $price->orderBy('quantity', 'desc')->with('unit');
                }])
                ->when($product_name, function ($product, $name){
                    $product->where('name', 'like', '%'.$name.'%')
                        ->orWhere('barcode', 'like', '%'.$name.'%');
                })
                ->when($category_id, function ($category, $id){
                    $category->where('category_id', $id);
                })->paginate($per_pages)
        ]);
    }

    public function show($id, Request $request)
    {
        $category_id        = $request->category_id  ?: '';
        $product = Product::query()
            ->with(['unit', 'stocks', 'prices.unit'])
            ->when($category_id, function ($category, $id){
                $category->where('category_id', $id);
            });
        return Excel::download(new ProductStockExport($category_id), now()->format('d-m-Y')  . '-stock.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function edit($id, Request $request)
    {
        dd($request->all());
    }
}
