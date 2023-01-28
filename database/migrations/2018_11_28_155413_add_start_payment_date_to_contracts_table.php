<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartPaymentDateToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('payment_day','start_payment_month');
            $table->date("start_payment_date")->after("start_payment_number")->default("1900-01-01");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('start_payment_date');
            $table->unsignedSmallInteger("payment_day")->default(1)->after("start_payment_number");
            $table->unsignedSmallInteger("start_payment_month")->default(1)->after("payment_day");
        });
    }
}
