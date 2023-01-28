<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelReasonToUnitContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_contract_requests', function (Blueprint $table) {
            $table->string('cancel_reason',500)
                  ->nullable(true)
                  ->default("")
                  ->after('status');
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
            $table->dropColumn(['cancel_reason']);
        });
    }
}
