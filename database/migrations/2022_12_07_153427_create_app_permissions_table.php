<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPermissionsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('app_permissions', function (Blueprint $table) {
         $table->id();
         $table->string('user_code');
         $table->string('van_sales')->default("YES");
         $table->string('new_sales')->default("YES");
         $table->string('deliveries')->default("YES");
         $table->string('schedule_visits')->default("YES");
         $table->string('merchanizing')->default("YES");
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
      Schema::dropIfExists('app_permissions');
   }
}
