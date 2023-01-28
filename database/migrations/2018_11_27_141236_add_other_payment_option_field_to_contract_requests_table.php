<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherPaymentOptionFieldToContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->unsignedSmallInteger("payment_option_id")->nullable(true)->change();
            
            $table->unsignedSmallInteger("loan_duration")->nullable(true)->after("payment_option_id");
            $table->double("interest",5,2)->nullable(true)->after("loan_duration");
            $table->double("special_discount",5,2)->nullable(true)->after("interest");
            $table->boolean("is_first_payment")->default(false)->after("special_discount");
            $table->unsignedSmallInteger("first_payment_duration")->nullable(true)->after("is_first_payment");
            $table->double("first_payment_percentage",5,2)->nullable(true)->after("first_payment_duration");
            $table->double("first_payment_amount",11,2)->nullable(true)->after("first_payment_percentage");

            $table->unsignedSmallInteger("payment_month")->nullable(false)->after("payment_day");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->unsignedSmallInteger("payment_option_id")->nullable(false)->change();

            $table->dropColumn([
                "loan_duration",
                "interest",
                "special_discount",
                "is_first_payment",
                "first_payment_duration",
                "first_payment_percentage",                
                "first_payment_amount",
                "payment_month"
            ]);
        });
    }
}
