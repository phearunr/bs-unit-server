<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->unsignedInteger("unit_action_id")->after("unit_type_id")->nullable(true);

            $table->foreign("unit_type_id")->references('id')->on('unit_types');
            $table->foreign('unit_action_id')->references('id')->on('unit_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign('units_unit_type_id_foreign');
            $table->dropForeign('units_unit_action_id_foreign');

            $table->dropColumn('unit_action_id');
        });
    }
}
