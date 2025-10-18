<?php

namespace App\Models;

use App\Enums\ClientAccountTransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;

class ClientAccountTransaction extends Model
{
    protected $table = 'client_account_transactions';
    public $timestamps = true;

    protected $fillable = [
        'type',
        'amount',
        'description',
        'balance_after',
        'client_id',
        'user_id',
        // morph fields (if you want to mass assign references)
        'reference_id',
        'reference_type',
    ];

    protected $casts = [
        'type' => ClientAccountTransactionTypeEnum::class,
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function reference()
    {
        return $this->morphTo();
    }
}

