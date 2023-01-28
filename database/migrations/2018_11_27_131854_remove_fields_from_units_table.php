<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsFromUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->double("annual_management_fee",11,2)->nullable(true)->default(0)->after("price");
            $table->double("contract_transfer_fee",11,2)->nullable(true)->default(0)->after("annual_management_fee");
            $table->double("management_fee_per_square",11,2)->nullable(true)->default(0)->after("contract_transfer_fee");

            $table->unsignedSmallInteger("deadline")->nullable(true);
            $table->unsignedSmallInteger("extended_deadline")->nullable(true);
            $table->text("title_clause_kh")->nullable(true);
            $table->text("management_serviec_kh")->nullable(true);
        });
    }
}
