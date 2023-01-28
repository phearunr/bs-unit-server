<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitHandoverBatchIdToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedInteger('unit_handover_batch_id')
                  ->nullable()
                  ->after('is_published');
            $table->foreign('unit_handover_batch_id')
                  ->references('id')->on('unit_handover_batches')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_unit_handover_batch_id_foreign');
            $table->dropColumn(['unit_handover_batch_id']);
        });
    }
}
