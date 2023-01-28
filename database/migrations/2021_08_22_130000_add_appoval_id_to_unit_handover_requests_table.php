<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppovalIdToUnitHandoverRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_handover_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('approval_id')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_handover_requests', function (Blueprint $table) {
            $table->dropColumn(['approval_id']);
        });
    }
}
