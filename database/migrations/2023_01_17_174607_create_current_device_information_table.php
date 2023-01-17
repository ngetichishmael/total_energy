<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentDeviceInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_device_information', function (Blueprint $table) {
            $table->id();
            $table->string("user_code");
            $table->string("current_gps")->nullable();
            $table->string("current_battery_percentage")->nullable();
            $table->string("device_code")->nullable();
            $table->string("IMEI")->nullable();
            $table->string("fcm_token")->nullable();
            $table->string("android_version")->nullable();
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
        Schema::dropIfExists('current_device_information');
    }
}