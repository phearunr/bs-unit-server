<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerName2AndCustomerRelationship2ToUnitHandoverRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_handover_requests', function (Blueprint $table) {
            $table->string('customer_name2')->after('customer_relationship')->nullable();
            $table->string('customer_relationship2')->after('customer_name2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_handover_requests', function (Blueprint $table) {
            $table->dropColumn(['customer_name2']);
            $table->dropColumn(['customer_relationship2']);
        });
    }
}
