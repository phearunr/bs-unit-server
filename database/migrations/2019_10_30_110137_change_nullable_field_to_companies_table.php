<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableFieldToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string("name_en")
                  ->nullable(true)
                  ->change();
            $table->string("name_zh")
                  ->nullable(true)
                  ->change();
            $table->string('address_line1_zh')
                  ->nullable(true)
                  ->change();
            $table->string('address_line2_zh')
                  ->nullable(true)
                  ->change();
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
            $table->string("name_en")
                  ->nullable(false)
                  ->change();
            $table->string("name_zh")
                  ->nullable(false)
                  ->change();
            $table->string('address_line1_zh')
                  ->nullable(false)
                  ->change();
            $table->string('address_line2_zh')
                  ->nullable(false)
                  ->change();
        });
    }
}
