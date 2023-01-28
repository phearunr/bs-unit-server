<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameZhAddressFiledToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string("name_zh")
                  ->after('name_en')
                  ->nullable(true);
            $table->string('address_line1_zh')
                  ->after('address_line1')
                  ->nullable(true);
            $table->string('address_line2_zh')
                  ->after('address_line2')
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
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['name_zh', 'address_line1_zh', 'address_line2_zh']);
        });
    }
}
