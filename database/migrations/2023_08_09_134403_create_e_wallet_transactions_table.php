<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('customer_id');
            $table->string('payment_type');
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_wallet_transactions');
    }
}
