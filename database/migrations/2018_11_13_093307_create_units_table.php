<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedSmallInteger("unit_type_id");
            $table->string("code",200)->unique()->index();
            $table->string("status",200)->nullable(true)->default("Available");
            $table->double("price",11,2);
            $table->double("annual_management_fee",11,2)->nullable(true)->default(0);
            $table->double("contract_transfer_fee",11,2)->nullable(true)->default(0);
            $table->double("management_fee_per_square",11,2)->nullable(true)->default(0);
            $table->string("street",200)->nullable(true);
            $table->string("street_corner",200)->nullable(true);
            $table->double("street_size")->nullable(true);
            $table->string("floor",200)->nullable(true);
            $table->double("land_size_width",11,2)->nullable(true);
            $table->double("land_size_length",11,2)->nullable(true);
            $table->double("building_size_width",11,2)->nullable(true);
            $table->double("building_size_length",11,2)->nullable(true);
            $table->double("total_area_size",11,2)->nullable(true);            
            $table->unsignedSmallInteger("living_room")->nullable(true);
            $table->unsignedSmallInteger("kitchen")->nullable(true);
            $table->unsignedSmallInteger("bedroom")->nullable(true);
            $table->unsignedSmallInteger("bathroom")->nullable(true);
            $table->unsignedSmallInteger("deadline")->nullable(true);
            $table->unsignedSmallInteger("extended_deadline")->nullable(true);
            $table->text("title_clause_kh")->nullable(true);
            $table->text("management_serviec_kh")->nullable(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
