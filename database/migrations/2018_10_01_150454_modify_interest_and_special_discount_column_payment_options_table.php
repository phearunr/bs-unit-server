<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyInterestAndSpecialDiscountColumnPaymentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_options', function (Blueprint $table) {
            $table->float("interest",5,2)->default(0)->change();
            $table->float("special_discount",5,2)->default(0)->change();
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
            $table->unsignedSmallInteger('interest')->default(0)->change();
            $table->smallInteger('special_discount')->unsigned()->default(0)->change();
        });
    }
}
