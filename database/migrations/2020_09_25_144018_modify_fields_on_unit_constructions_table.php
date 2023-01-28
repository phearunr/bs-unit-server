<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyFieldsOnUnitConstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_constructions', function (Blueprint $table) {
            $table->dropColumn(['progress']);

            $table->unsignedTinyInteger('foundation')->default(0)->after('unit_id');
            $table->unsignedTinyInteger('structure')->default(0)->after('foundation');
            $table->unsignedTinyInteger('finishing')->default(0)->after('structure');
            $table->unsignedTinyInteger('infrastructure')->default(0)->after('finishing');
            $table->unsignedTinyInteger('mep')->default(0)->after('infrastructure');
            $table->date('actual_completed_at')->nullable(true)->default(null)->after('estimate_completed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_constructions', function (Blueprint $table) {
            $table->dropColumn(['foundation', 'structure', 'finishing', 'infrastructure', 'mep', 'actual_completed_at']);
            $table->unsignedTinyInteger('progress')->default(0)->after('unit_id');
        });
    }
}
