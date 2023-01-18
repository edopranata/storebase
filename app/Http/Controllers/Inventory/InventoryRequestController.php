<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\TempPurchase;
use App\Models\TempPurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryRequestController extends Controller
{
    public function index()
    {
        $purchases = TempPurchase::query()
            ->where('user_id', auth()->id())
            ->first();

        if($purchases){
            return to_route('app.inventory.request.edit', $purchases->id);
        }
        return inertia('App/Inventory/InventoryRequest', [
            'purchases'     => $purchases
        ]);
    }

    public function edit(Request $req, TempPurchase $request)
    {
        $purchases = TempPurchase::query()
            ->with([
                'details.product.prices.unit',
                'details.product.stocks',
                'details.product.unit',
                'details.price.unit'
            ])
            ->where('user_id', auth()->id())
            ->first();
        return inertia('App/Inventory/InventoryRequestCreate', [
            'purchases'     => $purchases
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'supplier_id'       => ['nullable', 'exists:suppliers,id'],
            'invoice_number'    => ['required'],
            'invoice_date'      => ['required', 'date', 'before_or_equal:now'],
        ]);

        DB::beginTransaction();
        try {
            $supplier = Supplier::query()
                ->find($request->supplier_id);

            $purchase = \auth()->user()->tempPurchase()
                ->create([
                    'supplier_id'       => $request->supplier_id,
                    'supplier_name'     => $supplier->name,
                    'invoice_number'    => $request->invoice_number,
                    'invoice_date'      => $request->invoice_date,
                ]);
            DB::commit();
            return redirect()->route('app.inventory.request.edit', $purchase->id)->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => 'Data berhasil disimpan'
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

    public function delete(TempPurchaseDetail $purchase)
    {
        DB::beginTransaction();
        try {
            $purchase->delete();
            DB::commit();
            return TempPurchase::query()
                ->with([
                    'details.product.prices.unit',
                    'details.product.stocks',
                    'details.product.unit',
                    'details.price.unit'
                ])
                ->where('user_id', auth()->id())
                ->first();
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data gagal disimpan: " . $exception->getMessage()
            ]);

        }
    }

    public function add(Request $req, TempPurchase $purchase)
    {
        DB::beginTransaction();
        try {

            $product = Product::query()
                ->with(['prices', 'stocks'])
                ->where('id', $req->product_id)
                ->first();

            $purchase->load('details');
            // set satuan default adalah yang terakhir (Satuan terbesar)

            $price = $product->prices->last();
            // cek harga modal terakhir beli (jika ada)
            $stock = $product->stocks->last();

            // Tambahkan produk ke table temp (tabel sementara)
            $purchase->details()
                ->create([
                    'product_id' => $product->id,
                    'product_price_id' => $price->id,
                    'product_name' => $product->name,
                    'quantity' => 1,
                    'product_price_quantity' => $price->quantity,
                    'buying_price' => 0,
                    'total' => 0,
                ]);

            DB::commit();

            return $purchase->refresh()->load([
                'details.product.prices.unit',
                'details.product.stocks',
                'details.product.unit',
                'details.price.unit'
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function update(Request $request, TempPurchaseDetail $purchase)
    {
        DB::beginTransaction();
        try {
            $temp_purchase = $purchase->load(['product.prices.unit', 'product.stocks', 'price.unit']);

            $p_prices = $temp_purchase->product->prices->where('id', $request->product_price_id)->first();

            $temp_purchase->update([
                'product_price_id'          => $request->product_price_id,
                'quantity'                  => $request->quantity,
                'product_price_quantity'    => $request->quantity * $p_prices->quantity,
                'buying_price'              => $request->buying_price,
                'total'                     => $request->buying_price * $request->quantity,
            ]);

            DB::commit();
            return TempPurchase::query()
                ->with([
                    'details.product.prices.unit',
                    'details.product.stocks',
                    'details.product.unit',
                    'details.price.unit'
                ])
                ->where('user_id', auth()->id())
                ->first();
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Proses gagal: " . $exception->getMessage()
            ]);
        }
    }

    public function destroy(TempPurchase $request)
    {
        DB::beginTransaction();
        try {
            $purchase = \auth()->user()->tempPurchase()->with(['details'])->first();
            $purchase->details()->delete();
            $purchase->delete();

            DB::commit();
            return redirect()->route('app.inventory.request.index')->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => 'Transaksi dibatalkan'
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Proses gagal: " . $exception->getMessage()
            ]);
        }
    }

    public function show(TempPurchase $request)
    {
        $request->load([
            'details.product.prices.unit',
            'details.product.stocks.supplier',
            'details.product.unit',
            'details.price.unit'
        ]);
        return inertia('App/Inventory/InventoryRequestPreview', [
            'purchases'     => $request
        ]);
    }

}
