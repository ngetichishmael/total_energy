<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesaPaymentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('mpesa_payments', function (Blueprint $table) {
         $table->id();
         $table->string('account');
         $table->string('checkout_request_id');
         $table->string('phone');
         $table->string('amount');
         $table->string('purpose');
         $table->string('transaction_reference')->nullable();
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
      Schema::dropIfExists('mpesa_payments');
   }
}
