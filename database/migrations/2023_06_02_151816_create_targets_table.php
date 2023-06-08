<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_group_id');
            $table->foreign('target_group_id')->references('id')->on('target_groups');
            $table->unsignedBigInteger('target_type_id');
            $table->foreign('target_type_id')->references('id')->on('target_types');
            $table->unsignedBigInteger('measurement_unit_id');
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units');
            $table->unsignedBigInteger('sales_person_id');
            $table->foreign('sales_person_id')->references('id')->on('users');
            $table->double('target_value');
            $table->double('achieved_value')->nullable();
            $table->timestamp('deadline');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('targets');
    }
}
