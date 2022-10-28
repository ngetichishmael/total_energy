<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTargetsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('leads_targets', function (Blueprint $table) {
         $table->id();
         $table->string('user_code');
         $table->string('LeadsTarget');
         $table->string('AchievedLeadsTarget')->default('0');
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
      Schema::dropIfExists('leads_targets');
   }
}
