<?php

namespace App\Models;

use App\Enums\WarehouseTransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;

class WarehouseTransaction extends Model
{

    protected $fillable = ['warehouse_id', 'transaction_type', 'reference_id', 'reference_type', 'user_id',
        'quantity', 'quantity_after', 'description'];

    protected $casts = [
        'transaction_type' => WarehouseTransactionTypeEnum::class,
    ];
}
