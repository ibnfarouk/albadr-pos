<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_account_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->nullableMorphs('reference');
            $table->text('description');
            $table->decimal('balance_after', 10, 2);
            $table->tinyInteger('type');// ClientAccountTransactionTypeEnum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_account_transactions');
    }
};
