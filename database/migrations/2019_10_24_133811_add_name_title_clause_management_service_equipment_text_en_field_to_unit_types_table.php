<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameTitleClauseManagementServiceEquipmentTextEnFieldToUnitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_types', function (Blueprint $table) {
            $table->string("name_en")
                  ->after('name')
                  ->nullable(true);
            $table->text("title_clause_en")
                  ->after('title_clause_kh')
                  ->nullable(true);
            $table->text("management_service_en")
                  ->after('management_service_kh')
                  ->nullable(true);
            $table->text("equipment_text_en")
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
            $table->dropColumn(['name_en', 'title_clause_en', 'management_service_en', 'equipment_text_en']);
        });
    }
}
