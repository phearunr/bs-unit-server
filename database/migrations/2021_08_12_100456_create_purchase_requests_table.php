<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedSmallInteger('purchase_request_project_id');
            $table->unsignedSmallInteger('department_id');         
            $table->string('mrp_no',100)->nullable(true);
            $table->string('status',100)->default('Draft');
            $table->string('shipment_contact_name',100);
            $table->string('shipment_contact_number',100);
            $table->string('shipment_address_line1',250)->nullable();
            $table->string('shipment_address_line2',250)->nullable();
            $table->string('remark',500)->nullable(true);
            $table->timestamps();
           
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('purchase_request_project_id')->references('id')->on('purchase_request_projects');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_requests');
    }
}
