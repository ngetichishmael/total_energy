<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationshipsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('relationships', function (Blueprint $table) {
         $table->id();
         $table->string('name');
         $table->string('has_children')->default(0);
         $table->string('region_id')->nullable();
         $table->string('parent_id')->nullable();
         $table->string('level_id')->default(0);
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
      Schema::dropIfExists('relationships');
   }
}
