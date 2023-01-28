<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNationalityFieldToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string("customer1_nationality")
                  ->default("ខ្មែរ")
                  ->after('customer1_birthdate');
            $table->string("customer2_nationality")
                  ->default("ខ្មែរ")                  
                  ->after('customer2_birthdate');
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
            $table->dropColumn(['customer1_nationality', 'customer2_nationality']);
        });
    }
}
