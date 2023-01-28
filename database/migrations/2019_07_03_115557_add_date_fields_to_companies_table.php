<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateFieldsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->date('tax_issued_date')
                  ->default('1990-01-01')
                  ->after('tax_no');
            $table->date('commercial_license_issued_date')
                  ->default('1990-01-01')
                  ->after('commercial_license_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['tax_issued_date', 'commercial_license_issued_date']);
        });
    }
}
