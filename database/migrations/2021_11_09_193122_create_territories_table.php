<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerritoriesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('territories', function (Blueprint $table) {
         $table->id();
         $table->char('code');
         $table->char('name');
         $table->char('parent_code')->nullable();
         $table->char('status');
         $table->char('business_code');
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
      Schema::dropIfExists('territories');
   }
}
