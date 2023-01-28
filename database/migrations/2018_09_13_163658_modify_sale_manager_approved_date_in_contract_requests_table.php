<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySaleManagerApprovedDateInContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->renameColumn('sale_manager_aproved_date', 'sale_manager_approved_date');
             $table->renameColumn('unit_controller_aproved_date', 'unit_controller_approved_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
             $table->renameColumn('sale_manager_approved_date', 'sale_manager_aproved_date');
             $table->renameColumn('unit_controller_approved_date', 'unit_controller_aproved_date');
        });
    }
}
