<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DiscountTypeEnum;
use App\Enums\ItemStatusEnum;
use App\Enums\SafeStatusEnum;
use App\Enums\UnitStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Item;
use App\Models\Safe;
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

    public function store(Request $request)
    {
        dd($request->all());
    }
}
