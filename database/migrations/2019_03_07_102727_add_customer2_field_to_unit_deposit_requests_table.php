<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomer2FieldToUnitDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_deposit_requests', function (Blueprint $table) {
            $table->string('customer2_name',255)                  
                  ->nullable(true)
                  ->default("")
                  ->after('customer_gender');
            $table->unsignedTinyInteger('customer2_gender')
                  ->default(0)
                  ->after('customer2_name');
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
            $table->dropColumn(['customer2_name','customer2_gender']);
        });
    }
}
