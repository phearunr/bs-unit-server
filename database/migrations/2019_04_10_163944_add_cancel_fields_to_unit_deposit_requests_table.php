<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelFieldsToUnitDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) {
            $table->unsignedInteger('canceled_by_id')->nullable(true)->after('sale_manager_actioned_at');
            $table->dateTime('canceled_at')->nullable(true)->after('cancel_reason');

            $table->foreign('canceled_by_id')->references('id')->on('users');
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
            $table->dropForeign(['canceled_by_id']);
            $table->dropColumn(['canceled_by_id', 'canceled_at']);
        });
    }
}
