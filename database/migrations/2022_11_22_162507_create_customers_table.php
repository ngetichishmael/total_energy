<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('customers', function (Blueprint $table) {
         $table->id();
         $table->string("customer_name");
         $table->string("account");
         $table->string("manufacturer_number");
         $table->string("vat_number");
         $table->string("approval");
         $table->time("delivery_time");
         $table->string("address");
         $table->string("city");
         $table->string("province");
         $table->string("postal_code");
         $table->string("country");
         $table->string("latitude");
         $table->string("longitude");
         $table->string("contact_person");
         $table->string("telephone");
         $table->text("customer_group");
         $table->text("customer_secondary_group");
         $table->string("price_group");
         $table->string("route");
         $table->string("branch");
         $table->string("status");
         $table->string("email");
         $table->string("image");
         $table->string("phone_number");
         $table->string("business_code");
         $table->string("created_by");
         $table->string("updated_by");
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
      Schema::dropIfExists('customers');
   }
}
