<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryAllocatedItemsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('inventory_allocated_items', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('allocation_code');
         $table->char('product_code');
         $table->char('current_qty');
         $table->char('allocated_qty');
         $table->char('returned_qty');
         $table->char('created_by');
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
      Schema::dropIfExists('inventory_allocated_items');
   }
}
