<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCheckinTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('customer_checkin', function (Blueprint $table) {
         $table->id();
         $table->char('code')->nullable();
         $table->integer('customer_id')->nullable();
         $table->char('account_number',255)->nullable();
         $table->char('checkin_type')->nullable();
         $table->integer('user_id')->nullable();
         $table->char('ip',255)->nullable();
         $table->time('start_time');
         $table->time('stop_time')->nullable();
         $table->text('notes')->nullable();
         $table->text('cancellation_reason')->nullable();
         $table->text('adjusment_reason')->nullable();
         $table->char('order_number')->nullable();
         $table->char('amount')->nullable();
         $table->char('order_status')->nullable();
         $table->char('order_type')->nullable();
         $table->date('delivery_date')->nullable();
         $table->time('delivery_time')->nullable();
         $table->date('next_delivery_date')->nullable();
         $table->time('next_delivery_time')->nullable();
         $table->integer('approved_by')->nullable();
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
      Schema::dropIfExists('customer_checkin');
   }
}
