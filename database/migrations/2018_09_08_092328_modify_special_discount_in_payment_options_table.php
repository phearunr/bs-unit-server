<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySpecialDiscountInPaymentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Need to uuse smallInteger, cause the stupid Doctrin/DBal does not
        // support the unsignedTinyInteger
        Schema::table('payment_options', function (Blueprint $table) {
            $table->smallInteger('special_discount')->unsigned()->default(0)->change();
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
            $table->decimal('special_discount',8,2)->default(0)->change();
        });
    }
}
