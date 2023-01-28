<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnitFieldsFromContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                "unit_type_id",
                "unit_code",
                "unit_street",
                "unit_street_corner",
                "unit_floor",
                "unit_land_width",
                "unit_land_length",
                "unit_house_width",
                "unit_house_length",
                "unit_total_area"
            ]);
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
            $table->unsignedSmallInteger("unit_type_id")->after("agent_remark");
            $table->string('unit_code',100)->after("unit_type_id");
            $table->string('unit_street',200)->default("")->after("unit_id");
            $table->string('unit_street_corner',100)->nullable(true)->default("")->after('unit_street');
            $table->string('unit_floor',100)->nullable(true)->default("")->after('unit_street_corner');
            $table->double('unit_land_width',8,2)->default(0)->after('unit_floor');
            $table->double('unit_land_length',8,2)->default(0)->after('unit_land_width');
            $table->double('unit_house_width',8,2)->default(0)->after('unit_land_length');
            $table->double('unit_house_length',8,2)->default(0)->after('unit_house_width');     
            $table->double('unit_total_area',11,2)->nullable(true)->default(0)->after("unit_house_length");      
        });
    }
}
