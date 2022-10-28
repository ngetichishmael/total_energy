<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTargetsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('sales_targets', function (Blueprint $table) {
         $table->id();
         $table->string('user_code');
         $table->string('SalesTarget');
         $table->string('AchievedSalesTarget')->default('0');
         $table->date('Deadline')->nullable();
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
      Schema::dropIfExists('sales_targets');
   }
}
