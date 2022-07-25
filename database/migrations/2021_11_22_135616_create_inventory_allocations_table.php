<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryAllocationsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('inventory_allocations', function (Blueprint $table) {
         $table->id();
         $table->char('business_code');
         $table->char('allocation_code');
         $table->char('sales_person');
         $table->date('date_allocated');
         $table->char('status');
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
      Schema::dropIfExists('inventory_allocations');
   }
}
