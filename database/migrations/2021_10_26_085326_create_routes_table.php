<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('routes', function (Blueprint $table) {
         $table->id();
         $table->char('businessID');
         $table->char('route_code');
         $table->char('name');
         $table->char('status');
         $table->date('start_date');
         $table->date('end_date');
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
      Schema::dropIfExists('routes');
   }
}
