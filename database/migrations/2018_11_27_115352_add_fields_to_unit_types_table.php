<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUnitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_types', function (Blueprint $table) {
            $table->double("annual_management_fee",11,2)->default(0)->after("short_code");
            $table->double("contract_transfer_fee",11,2)->default(0)->after("annual_management_fee");
            $table->double("management_fee_per_square",11,2)->default(0)->after("contract_transfer_fee");
            $table->unsignedSmallInteger("deadline")->default(0)->after("management_fee_per_square");
            $table->unsignedSmallInteger("extended_deadline")->after("deadline");
            $table->text("title_clause_kh")->after("extended_deadline");
            $table->text("management_serviec_kh")->after("title_clause_kh");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_types', function (Blueprint $table) {
            $table->dropColumn([
                "annual_management_fee",
                "contract_transfer_fee",
                "management_fee_per_square",
                "deadline",
                "extended_deadline",
                "title_clause_kh",
                "management_serviec_kh"
            ]);
        });
    }
}
