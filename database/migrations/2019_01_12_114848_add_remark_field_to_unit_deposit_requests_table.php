<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarkFieldToUnitDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) {
            $table->string("remark", 500)
                  ->default("")
                  ->nullable(true)
                  ->after("status");
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
            $table->dropColumn(['remark']);
        });
    }
}
