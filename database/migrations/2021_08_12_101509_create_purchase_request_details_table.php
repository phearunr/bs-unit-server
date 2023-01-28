<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('purchase_request_id');
            $table->string('item_code', 100);
            $table->string('description', 500);
            $table->string('unit_of_measurement',100);
            $table->double('quantity', 12, 2);
            $table->date('expected_arrival_date');
            $table->string('purpose',500);
            
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_request_details');
    }
}
