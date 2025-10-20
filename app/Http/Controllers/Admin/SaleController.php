<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ClientAccountTransactionTypeEnum;
use App\Enums\DiscountTypeEnum;
use App\Enums\ItemStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Enums\SafeStatusEnum;
use App\Enums\SafeTransactionTypeEnum;
use App\Enums\UnitStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaleRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Item;
use App\Models\Safe;
use App\Models\Sale;
use App\Models\Unit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * @return Factory|View|\Illuminate\View\View
     */
    public function create()
    {
        $clients = Client::all();
        //todo : from settings
        $safes = Safe::where('status', SafeStatusEnum::active)->get();
        $units = Unit::where('status', UnitStatusEnum::active)->get();
        $items = Item::where('status', ItemStatusEnum::active)->get();
        $discountTypes = DiscountTypeEnum::labels();
        return view(
            'admin.sales.create',
            compact('clients', 'safes', 'units', 'items', 'discountTypes')
        );
    }

    public function store(SaleRequest $request)
    {
        DB::beginTransaction();
        //dd($request->all());
        $sale = auth()->user()->sales()->create($request->validated());// db
        $total = 0;
        $discount = 0;
        $remaining = 0;
        foreach ($request->items as $id => $item) {
            $queriedItem = Item::find($id);
            $totalPrice = $queriedItem->price * $item['qty'];
            $sale->items()->attach([// db
                $item['id'] => [
                    'unit_price' => $item['price'],
                    'quantity' => $item['qty'],
                    'total_price' => $totalPrice,
                    'notes' => $item['notes'],
                ]
            ]);
            // stock update
            $queriedItem->decrement('quantity', $item['qty']);
            $total += $totalPrice;
        }
        if ($request->discount_type == DiscountTypeEnum::percentage->value){
            $discount = $total * ($request->discount/100);
        }else{
            $discount = $request->discount;
        }
        $net = $total - $discount;
        if ($request->payment_type == PaymentTypeEnum::debt->value){
            $paid = $request->payment_amount;
        }else{
            $paid = $net;
        }
        $remaining = $net - $paid;
        $sale->total = $total;
        $sale->discount = $discount;
        $sale->net_amount = $net;
        $sale->paid_amount = $paid;
        $sale->remaining_amount = $remaining;
        $sale->save();//db
        // update safe & transaction
        if ($paid > 0) {
            $sale->safe->increment('balance', $paid);
            $sale->safeTransactions()->create([
                'user_id' => auth()->user()->id,
                'type' => SafeTransactionTypeEnum::in,
                'safe_id' => $request->safe_id,
                'amount' => $paid,
                'balance_after' => $sale->safe->fresh()->balance,
                'description' => 'Sale Payment, Invoice #: ' . $sale->invoice_number,
            ]);
        }
        if ($remaining) {
            $sale->client->increment('balance', $remaining);
            $sale->clientAccountTransaction()->create([
                'user_id' => auth()->user()->id,
                'type' => ClientAccountTransactionTypeEnum::credit,
                'client_id' => $request->client_id,
                'amount' => $remaining,
                'balance_after' => $sale->client->fresh()->balance,
                'description' => 'Sale Remaining Amount, Invoice #: ' . $sale->invoice_number,
            ]);
        }

        // client account update

        DB::commit();
        return back();
    }
}
