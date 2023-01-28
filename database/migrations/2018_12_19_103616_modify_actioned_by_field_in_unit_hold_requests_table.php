<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyActionedByFieldInUnitHoldRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_hold_requests', function (Blueprint $table) {
            $table->renameColumn('actioned_by', 'actioned_user_id');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_hold_requests', function (Blueprint $table) {
            $table->renameColumn('actioned_user_id', 'actioned_by');       
        });
    }
}
