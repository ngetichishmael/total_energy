<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKOCustomersTable extends Migration
{
   public function up()
   {
      Schema::create('m_k_o_customers', function (Blueprint $table) {
         $table->id();
         $table->string('odoo_uuid')->nullable();
         $table->string('soko_uuid')->nullable();
         $table->string('source')->nullable();
         $table->string('company_type')->nullable();
         $table->string('image')->nullable();
         $table->string('customer_name')->nullable();
         $table->string('phone_number')->nullable();
         $table->string('telephone')->nullable();
         $table->string('mobile')->nullable();
         $table->string('email')->nullable();
         $table->string('type')->nullable();
         $table->string('street')->nullable();
         $table->string('city')->nullable();
         $table->string('postal_code')->nullable();
         $table->string('country')->nullable();
         $table->string('contact_person')->nullable();
         $table->float('latitude')->default(0.0);
         $table->float('longitude')->default(0.0);
         $table->string('manufacturer_number')->nullable();
         $table->string('route')->nullable();
         $table->string('route_code')->nullable();
         $table->string('region')->nullable();
         $table->string('subregion')->nullable();
         $table->string('zone')->nullable();
         $table->string('unit')->nullable();
         $table->string('branch')->nullable();
         $table->string('business_code')->nullable();
         $table->tinyInteger('merged')->default(0);
         $table->timestamps();
      });
   }

   public function down()
   {
      Schema::dropIfExists('m_k_o_customers');
   }
}
