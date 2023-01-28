<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_deposit_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("unit_id");
            $table->string('status');
            $table->double("unit_sale_price",12,2);            
            $table->double("discount_promotion",12,2)->default(0);
            $table->double("other_discount_allowance",12,2)->default(0);
            $table->double("deposit_amount",12,2);
            $table->date("deposited_at")->nullable(true);
            $table->double("receiving_amount")->default(0)->nullable(true);
            $table->date("received_at")->nullable(true);
            $table->unsignedSmallInteger("payment_option_id")->nullable(true);
            $table->unsignedSmallInteger("loan_duration")->nullable(true);
            $table->double("interest",5,2)->nullable(true);
            $table->double("special_discount",5,2)->nullable(true);
            $table->boolean("is_first_payment")->default(0);
            $table->unsignedSmallInteger("first_payment_duration")->nullable(true);
            $table->double("first_payment_percentage",5,2)->nullable(true);
            $table->double("first_payment_amount",12,2)->nullable(true);            
            $table->string('customer_name',200);
            $table->tinyInteger("customer_gender")->default(1);
            $table->string('customer_phone_number',200);
            $table->string('customer_phone_number2',200);
            $table->string("unit_controller_status",50)->default("PENDING");
            $table->unsignedInteger("unit_controller_id")->nullable(true);
            $table->dateTime('unit_controller_actioned_at')->nullable(true);
            $table->string("sale_manager_status",50)->default("PENDING");
            $table->unsignedInteger("sale_manager_id")->nullable(true);
            $table->dateTime('sale_manager_actioned_at')->nullable(true);
            // $table->unsignedSmallInteger("unit_controller_approve_id")->nullable(true);
            // $table->dateTime("unit_controller_approved_at")->nullable(true);
            // $table->unsignedSmallInteger("sale_manager_approve_id")->nullable(true);
            // $table->dateTime("sale_manager_approved_at")->nullable(true);
            // $table->unsignedSmallInteger("unit_controller_reject_id")->nullable(true);
            // $table->dateTime("unit_controller_rejected_at")->nullable(true);
            // $table->unsignedSmallInteger("sale_manager_reject_id")->nullable(true);
            // $table->dateTime("sale_manager_rejected_at")->nullable(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');          
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('payment_option_id')->references('id')->on('payment_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_deposit_requests');
    }
}
