<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarkFieldToUnitHoldRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_hold_requests', function (Blueprint $table) {
            $table->string("remark",500)->nullable(true)->default("")->after("unit_id");
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
            $table->dropColumn("remark");
        });
    }
}
