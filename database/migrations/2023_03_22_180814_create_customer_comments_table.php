<?php

use App\Models\customers;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCommentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('customer_comments', function (Blueprint $table) {
         $table->id();
         $table->foreignIdFor(User::class);
         $table->foreignIdFor(customers::class);
         $table->text('comment');
         $table->timestamp('date');
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
      Schema::dropIfExists('customer_comments');
   }
}
