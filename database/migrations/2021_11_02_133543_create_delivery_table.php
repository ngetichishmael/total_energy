<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('delivery', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('delivery_code');
         $table->char('order_code')->nullable();
         $table->char('allocated')->nullable();
         $table->text('delivery_note')->nullable();
         $table->char('delivery_status')->nullable();
         $table->char('customer')->nullable();
         $table->char('delivered_time')->nullable();
         $table->char('accept_allocation')->nullable();
         $table->char('customer_confirmation')->nullable();
         $table->char('created_by')->nullable();
         $table->char('updated_by')->nullable();
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
      Schema::dropIfExists('delivery');
   }
}
