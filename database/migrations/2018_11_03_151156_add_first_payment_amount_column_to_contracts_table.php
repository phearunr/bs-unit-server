<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstPaymentAmountColumnToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->double('first_payment_amount',11,2)->nullable(true)->default(null)->after("first_payment_percentage");
            $table->float('first_payment_percentage',11,2)->nullable(true)->default(null)->change();
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
            $table->dropColumn(['first_payment_amount']);
            $table->unsignedSmallInteger('first_payment_percentage')->default(0)->change();
        });
    }
}
