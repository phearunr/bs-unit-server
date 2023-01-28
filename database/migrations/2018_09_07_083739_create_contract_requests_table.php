<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('customer1_name',255);
            $table->unsignedTinyInteger('customer1_gender');
            $table->string('customer2_name',255)->nullable(true)->default("");
            $table->unsignedTinyInteger('customer2_gender')->default(0);
            $table->string('customer_phone_number',100);
            $table->string('agent_name',255);
            $table->unsignedTinyInteger('agent_gender')->default(0);
            $table->string('agent_phone_number',100);
            $table->string('agent_remark',500);
            $table->unsignedInteger('sale_team_leader_id');
            $table->date("unit_sold_date");
            $table->unsignedSmallInteger("unit_type_id");
            $table->string('unit_code',100);
            $table->double('unit_sold_price',11,2);
            $table->double('discount_promotion',11,2);
            $table->double('other_discount_allowed',11,2);
            $table->string('unit_remark',500);
            $table->double('deposited_amount',11,2);
            $table->date('deposited'); // changed to deposited_date
            $table->unsignedSmallInteger("payment_option_id");
            $table->date('payment_date');

            $table->unsignedInteger('unit_controller_approved')->nullable(true);    
            $table->dateTime("unit_controller_aproved_date")->nullable(true);

            $table->unsignedInteger('sale_manager_approved')->nullable(true);
            $table->dateTime("sale_manager_aproved_date")->nullable(true);

            $table->unsignedInteger("rejected_by")->nullable(true);
            $table->dateTime("rejected_date")->nullable(true);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users');

            $table->foreign('sale_team_leader_id')
                  ->references('id')->on('users');

            $table->foreign('unit_type_id')
                  ->references('id')->on("unit_types");

            $table->foreign('payment_option_id')
                  ->references('id')->on('payment_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_requests');
    }
}
