<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyFieldsToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->text("title_clause_kh")->nullable(true)->change();
            $table->text("management_service_kh")->nullable(true)->change();
            $table->text("equipment_text")->nullable(true)->change();
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
            $table->text("title_clause_kh")->nullable(false)->change();
            $table->text("management_service_kh")->nullable(false)->change();
            $table->text("equipment_text")->nullable(false)->change();
        });
    }
}
