<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrystalCustomersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crystal_customers', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('code');
         $table->string('id_code');
         $table->string('companyid');
         $table->unsignedInteger('cust_type');
         $table->string('group_id');
         $table->string('name');
         $table->string('glaccount');
         $table->boolean('active');
         $table->string('tel');
         $table->string('image');
         $table->string('email');
         $table->string('address');
         $table->date('startdate');
         $table->integer('bal');
         $table->unsignedBigInteger('rep');
         $table->unsignedInteger('creditlimit');
         $table->unsignedInteger('terms');
         $table->unsignedBigInteger('currency_id');
         $table->string('loccode');
         $table->unsignedBigInteger('region_id');
         $table->string('pinno');
         $table->timestamps();

         // Add foreign key constraints if necessary
         // $table->foreign('currency_id')->references('id')->on('currencies');
         // $table->foreign('region_id')->references('id')->on('regions'
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('crystal_customers');
   }
}
