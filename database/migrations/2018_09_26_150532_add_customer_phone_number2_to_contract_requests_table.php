<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerPhoneNumber2ToContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->string('customer_phone_number2',100)->nullable(true)->default("")->after('customer_phone_number');
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
            $table->dropColumn("customer_phone_number2");
        });
    }
}
