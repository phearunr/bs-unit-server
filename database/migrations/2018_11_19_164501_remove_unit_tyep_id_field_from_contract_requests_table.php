<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnitTyepIdFieldFromContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->dropForeign(['unit_type_id']);
            $table->dropColumn("unit_type_id","unit_code");
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
            $table->unsignedSmallInteger("unit_type_id")->nullable(true)->after("unit_sold_date");
            $table->string('unit_code',100)->after("unit_type_id");
            $table->foreign('unit_type_id')
                  ->references('id')->on("unit_types");
        });
    }
}
