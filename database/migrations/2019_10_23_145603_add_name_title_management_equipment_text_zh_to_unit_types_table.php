<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameTitleManagementEquipmentTextZhToUnitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_types', function (Blueprint $table) {
            $table->string("name_zh")
                  ->after('name')
                  ->nullable(true);
            $table->string("title_clause_zh")
                  ->after('title_clause_kh')
                  ->nullable(true);
            $table->string("management_service_zh")
                  ->after('management_service_kh')
                  ->nullable(true);
            $table->string("equipment_text_zh")
                  ->after('equipment_text')
                  ->nullable(true);
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
            $table->dropColumn(['name_zh', 'title_clause_zh', 'management_service_zh', 'equipment_text_zh']);
        });
    }
}
