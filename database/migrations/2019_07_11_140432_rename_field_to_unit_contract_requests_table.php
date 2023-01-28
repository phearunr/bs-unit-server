<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFieldToUnitContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_contract_requests', function (Blueprint $table) {
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
        Schema::table('unit_contract_requests', function (Blueprint $table) {
            $table->renameColumn('action_reason','cancel_reason');
        });
    }
}
