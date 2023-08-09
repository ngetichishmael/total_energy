<?php

use App\Models\User;
use App\Models\warehousing;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_requisitions', function (Blueprint $table) {
           $table->id();
           $table->foreignIdFor(User::class);
           $table->string('status')->default('Waiting Approval');
           $table->string('warehouse_code')->nullable();
           $table->timestamp('requisition_date');
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
        Schema::dropIfExists('stock_requisitions');
    }
}
