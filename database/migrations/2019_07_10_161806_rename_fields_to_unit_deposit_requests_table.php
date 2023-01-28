<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFieldsToUnitDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) {
            $table->renameColumn('canceled_by_id', 'actioned_user_id');
            $table->renameColumn('canceled_at', 'actioned_at');
            $table->renameColumn('cancel_reason', 'action_reason');
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
            $table->renameColumn('actioned_user_id', 'canceled_by_id');
            $table->renameColumn('actioned_at', 'canceled_at');
            $table->renameColumn('action_reason', 'cancel_reason');
        });
    }
}
