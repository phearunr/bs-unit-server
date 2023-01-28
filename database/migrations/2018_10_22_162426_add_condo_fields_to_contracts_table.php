<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCondoFieldsToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {           
            $table->double('service_fee',11,2)->nullable(true)->default(0)->after('unit_code');
            $table->double('unit_total_area',11,2)->nullable(true)->default(0)->after("unit_house_length");
            $table->string('unit_street_corner',100)->nullable(true)->default("")->after('unit_street');
            $table->string('unit_floor',100)->nullable(true)->default("")->after('unit_street_corner');
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
            $table->dropColumn(['service_fee','unit_total_area','unit_street_corner','unit_floor']);
        });
    }
}
