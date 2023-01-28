<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActionFieldsToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('reason', 500)
                  ->default(null)
                  ->nullable(true)
                  ->after('equipment_text');
            $table->unsignedInteger('actioned_user_id')
                  ->nullable(true)
                  ->after('reason');
            $table->dateTime('actioned_at')
                  ->nullable(true)
                  ->after('actioned_user_id');

            $table->foreign('actioned_user_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['actioned_user_id']);

            $table->dropColumn(['reason','actioned_user_id','actioned_at']);
        });
    }
}
