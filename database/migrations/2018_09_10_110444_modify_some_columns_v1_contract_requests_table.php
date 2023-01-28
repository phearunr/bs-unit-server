<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySomeColumnsV1ContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->dropColumn('rejected_by');
            $table->dropColumn('rejected_date');

            $table->unsignedInteger("unit_controller_rejected")->nullable(true)->after('sale_manager_aproved_date');
            $table->dateTime("unit_controller_rejected_date")->nullable(true)->after('unit_controller_rejected');

            $table->unsignedInteger("sale_manager_rejected")->nullable(true)->after('unit_controller_rejected_date');
            $table->dateTime("sale_manager_rejected_date")->nullable(true)->after('sale_manager_rejected');
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
            $table->unsignedInteger("rejected_by")->nullable(true)->after('sale_manager_aproved_date');
            $table->dateTime("rejected_date")->nullable(true)->after('rejected_by');

            $table->dropColumn("unit_controller_rejected");
            $table->dropColumn("unit_controller_rejected_date");

            $table->dropColumn("sale_manager_rejected");
            $table->dropColumn("sale_manager_rejected_date");
        });
    }
}
