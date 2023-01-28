<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnitFieldsInContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->dropColumn([
                "unit_street",
                "unit_land_width",
                "unit_land_length",
                "unit_house_width",
                "unit_house_length",
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
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->string('unit_street',200)->default("")->after("unit_id");
            $table->double('unit_land_width',8,2)->default(0)->after("unit_street");
            $table->double('unit_land_length',8,2)->default(0)->after("unit_land_width");
            $table->double('unit_house_width',8,2)->default(0)->after("unit_land_length");
            $table->double('unit_house_length',8,2)->default(0)->after("unit_house_width");
        });
    }
}
