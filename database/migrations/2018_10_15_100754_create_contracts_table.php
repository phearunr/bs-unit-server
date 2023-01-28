<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('contract_request_id')->nullable(true);
            $table->string('customer1_name',255);
            $table->unsignedTinyInteger('customer1_gender');
            $table->date('customer1_birthdate')->nullable(true)->default('1990-01-01');
            $table->string('customer1_nid',100)->nullable(true);
            $table->date('customer1_nid_issued_date')->nullable(true)->default('1990-01-01');
            $table->string('customer2_name',255)->nullable(true)->default("");
            $table->unsignedTinyInteger('customer2_gender')->default(0);
            $table->date('customer2_birthdate')->nullable(true)->default('1990-01-01');
            $table->string('customer2_nid',100)->nullable(true);
            $table->date('customer2_nid_issued_date')->nullable(true)->default('1990-01-01');
            $table->string('customer_phone_number',100);
            $table->string('customer_phone_number2',100)->nullable(true)->default("");

            $table->string("customer_house_no",100)->default("");
            $table->string("customer_street",100)->default("");
            $table->string("customer_phum",200)->default("");
            $table->string("customer_commune",200)->default("");
            $table->string("customer_district",200)->default("");
            $table->string("customer_city",200)->default("");

            $table->string('agent_name',255);
            $table->unsignedTinyInteger('agent_gender')->default(0);
            $table->string('agent_phone_number',100);
            $table->unsignedInteger('sale_team_leader_id');
            $table->string('agent_remark',500)->nullable(true)->default("");    
            $table->unsignedSmallInteger("unit_type_id");
            $table->string('unit_code',100);
            $table->date("unit_sold_date");
            $table->date("sign_date");
            $table->string('unit_street',200)->default("");
            $table->double('unit_land_width',8,2)->default(0);
            $table->double('unit_land_length',8,2)->default(0);
            $table->double('unit_house_width',8,2)->default(0);
            $table->double('unit_house_length',8,2)->default(0);
            $table->string('unit_remark',500)->nullable(true)->default("");

            $table->double('unit_sold_price',11,2);
            $table->double('discount_promotion',11,2);
            $table->double('other_discount_allowed',11,2);
            $table->double('deposited_amount',11,2);
            $table->date('deposited_date');
            $table->unsignedSmallInteger('payment_day');

            $table->unsignedTinyInteger('loan_duration')->default(0);            
            $table->float("interest",5,2)->default(0);
            $table->float("special_discount",5,2)->default(0);
            $table->boolean('is_first_payment')->default(0);
            $table->unsignedSmallInteger('first_payment_duration')->default(0);
            $table->unsignedSmallInteger('first_payment_percentage')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users');
            $table->foreign('sale_team_leader_id')
                  ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
