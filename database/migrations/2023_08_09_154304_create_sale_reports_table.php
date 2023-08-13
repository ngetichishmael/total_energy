<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_reports', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('customer_id');
            $table->string('checking_code');
            $table->enum('customer_ordered', ['Yes', 'No'])->default('No');
            $table->enum('outlet_has_stock', ['Yes', 'No'])->nullable();
            $table->string('competitor_supplier')->nullable();
            $table->json('likely_ordered_products')->nullable();
            $table->json('highest_sale_products')->nullable();
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
        Schema::dropIfExists('sale_reports');
    }
}
