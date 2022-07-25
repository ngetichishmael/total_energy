<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryItemsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('delivery_items', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('delivery_code');
         $table->char('delivery_item_code');
         $table->char('item_code')->nullable();
         $table->char('allocated_quantity')->nullable();
         $table->char('item_condition')->nullable();
         $table->text('note')->nullable();
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
      Schema::dropIfExists('delivery_items');
   }
}
