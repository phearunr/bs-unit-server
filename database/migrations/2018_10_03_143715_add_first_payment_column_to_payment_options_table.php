<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstPaymentColumnToPaymentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_options', function (Blueprint $table) {
            $table->boolean('is_first_payment')->default(0)->after("special_discount");
            $table->unsignedSmallInteger('first_payment_duration')->default(0)->after("is_first_payment");
            $table->unsignedSmallInteger('first_payment_percentage')->default(0)->after("first_payment_duration");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_options', function (Blueprint $table) {
            $table->dropColumn(['is_first_payment','first_payment_duration','first_payment_percentage']);
        });
    }
}
