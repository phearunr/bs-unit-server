<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonFieldToUnitDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) { 
            $table->string("unit_controller_reason", 500)->nullable(true)->default("")->after('unit_controller_id');
            $table->string("sale_manager_reason", 500)->nullable(true)->default("")->after('sale_manager_id');
            $table->string("cancel_reason", 500)->nullable(true)->default("")->after('sale_manager_actioned_at');
            $table->unsignedInteger('from_unit_deposit_request_id')->nullable(true)->after('cancel_reason');
            $table->unsignedInteger('to_unit_deposit_request_id')->nullable(true)->after('from_unit_deposit_request_id');
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
            $table->dropColumn([
                'unit_controller_reason',
                'sale_manager_reason',
                'cancel_reason',
                'from_unit_deposit_request_id',
                'to_unit_deposit_request_id'
            ]);
        });
    }
}
