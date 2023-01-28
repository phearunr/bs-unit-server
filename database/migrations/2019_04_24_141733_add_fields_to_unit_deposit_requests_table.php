<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUnitDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) {
            $table->string('document_no')
                  ->nullable(true)                  
                  ->default("")
                  ->after('receiving_amount');

            $table->string('entry_no')
                  ->nullable(true)
                  ->default("")
                  ->after('document_no');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) {
            $table->dropColumn(['document_no','entry_no']);
        });
    }
}
