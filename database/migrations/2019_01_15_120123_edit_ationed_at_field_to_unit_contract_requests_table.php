<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAtionedAtFieldToUnitContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_contract_requests', function (Blueprint $table) {
            $table->dateTime('actioned_at')->nullable(true)->change();
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
            $table->date('actioned_at')->nullable(true)->change();
        });
    }
}
