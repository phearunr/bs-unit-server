<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPaymentDateColumnInContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {            
            $table->dropColumn('payment_date');
            $table->unsignedTinyInteger("payment_day")->after('payment_option_id');
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
            $table->dropColumn("payment_day");
            $table->date('payment_date')->nullable(true)->after("payment_option_id");
        });
    }
}
