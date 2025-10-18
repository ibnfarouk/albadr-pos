<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DiscountTypeEnum;
use App\Enums\ItemStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Enums\SafeStatusEnum;
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
        //dd($request->all());
        $sale = auth()->user()->sales()->create($request->validated());
        $total = 0;
        $discount = 0;
        $remaining = 0;
        foreach ($request->items as $item) {
            $queriedItem = Item::find($item['id']);
            $totalPrice = $queriedItem->price * $item['qty'];
            $sale->items()->attach([
                $item['id'] => [
                    'unit_price' => $item['price'],
                    'quantity' => $item['qty'],
                    'total_price' => $totalPrice,
                    'notes' => $item['notes'],
                ]
            ]);
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
        $sale->save();
        return back();
    }
}
