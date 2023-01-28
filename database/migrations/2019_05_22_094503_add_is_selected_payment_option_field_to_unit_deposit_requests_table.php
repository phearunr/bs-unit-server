<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsSelectedPaymentOptionFieldToUnitDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) {
            $table->boolean('is_selected_payment_option')
                  ->default(true)
                  ->after('receiver_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) {
            $table->dropColumn(['is_selected_payment_option']);
        });
    }
}
