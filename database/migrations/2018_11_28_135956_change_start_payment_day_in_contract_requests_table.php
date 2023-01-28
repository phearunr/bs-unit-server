<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStartPaymentDayInContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->dropColumn(['payment_day', 'payment_month']);
            $table->date('start_payment_date')->after("first_payment_amount")->default('1990-01-01');
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
            $table->unsignedSmallInteger("payment_day")->default(1)->after("first_payment_amount");
            $table->unsignedSmallInteger("payment_month")->default(1)->after("payment_day");

            $table->dropColumn(['start_payment_date']);
        });
    }
}
