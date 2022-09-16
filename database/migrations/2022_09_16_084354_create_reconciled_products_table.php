<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReconciledProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reconciled_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('productID');            
            $table->bigInteger('amount');            
            $table->string('userCode');            
            $table->bigInteger('supplierID');
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
        Schema::dropIfExists('reconciled_products');
    }
}
