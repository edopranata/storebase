<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function supplier(Request $request)
    {
        return Supplier::query()->where('name',  'like', '%'.$request->search.'%')->get();
    }

    public function product(Request $request)
    {
        return Product::query()
            ->where('name',  'like', '%'.$request->search.'%')
            ->orWhere('barcode',  'like', '%'.$request->search.'%')
            ->get()->take(20)->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'name'      => $item->barcode . ' ' . $item->name
                ];
            });

    }
}
