<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractTemplateIdColumnToUnitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_types', function (Blueprint $table) {
            $table->unsignedInteger("contract_template_id")->nullable(true)->after('short_code');

            $table->foreign('contract_template_id')
                  ->references('id')->on('contract_templates');
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
            $table->dropForeign('unit_types_contract_template_id_foreign');
            $table->dropColumn("contract_template_id");
        });
        
        

    }
}
