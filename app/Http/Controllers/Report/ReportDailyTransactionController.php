<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use App\Models\SellReturn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportDailyTransactionController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $transaction_date = $request->date ?: now()->subDays(2)->toDateString();
        return inertia('App/Report/ReportTransaction', [
            'user_id'       => $request->user_id,
            'date'          => $transaction_date,
            'users'         => User::query()->get()->map(function ($item){
                return [
                    'id'    => $item->id,
                    'name'  => $item->username
                ];
            }),
            'transactions'  => Sell::query()
                ->when($user_id, function ($query, $user_id){
                    $query->where('user_id', $user_id);
                })
                ->when($transaction_date, function ($query, $transaction_date){
                    $query->whereDate('invoice_date', Carbon::createFromFormat('Y-m-d', $transaction_date));
                })
                ->with(['user', 'returns' => function($query) use ($transaction_date){
                    $query->when($transaction_date, function ($query_date, $date){
                        $query_date->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $date));
                    });
                }])
                ->withSum('details', 'total')
                ->withSum('details', 'discount')
                ->get()->map(function ($data) {
                    return [
                        'user'              => $data->user->username,
                        'invoice_number'    => $data->invoice_number,
                        'invoice_date'      => $data->invoice_date->format('d-m-Y'),
                        'customer'          => $data->customer_name,
                        'bill'              => $data->bill + $data->discount,
                        'discount'          => $data->discount,
                        'total'             => $data->bill,
                        'payment'           => $data->payment,
                        'refund'            => $data->payment - $data->bill,
                        'status'            => $data->status,
                        'sum_return'        => $data->returns->sum(function($return){
                            return $return['quantity'] * $return['sell_price'];
                        }),
                        'returns'           => $data->returns,

                    ];
                }),
            'returns'   => SellReturn::query()
                ->with(['user', 'price.unit', 'sell'])
                ->whereHas('sell', function ($sell) use ($transaction_date) {
                    $sell->whereDate('invoice_date', '<>', $transaction_date);
                })
                ->when($user_id, function ($query, $user_id){
                    $query->where('user_id', $user_id);
                })
                ->when($transaction_date, function ($query, $transaction_date){
                    $query->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $transaction_date));
                })
                ->get()->map(function ($data){
                    return [
                        'invoice_number'    => $data->sell->invoice_number,
                        'invoice_date'      => $data->sell->invoice_date->format('d-m-Y'),
                        'user'              => $data->user->username,
                        'product_name'      => $data->product_name,
                        'quantity'          => $data->quantity . ' ' .$data->price->unit->name,
                        'sell_price'        => $data->sell_price,
                        'total'             => $data->quantity * $data->sell_price,
                        'status'            => 'Retur'
                    ];
                }),
        ]);
    }
}
