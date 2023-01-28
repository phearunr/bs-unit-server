<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsOnContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            Schema::table('contracts', function (Blueprint $table) {
                $table->dropForeign(['sale_team_leader_id']);
                $table->dropColumn(['agent_name','agent_gender','agent_phone_number','sale_team_leader_id']);
                $table->renameColumn('sign_date', 'signed_at');
                $table->renameColumn('unit_sold_date', 'unit_sold_at');
                $table->renameColumn('unit_sold_price', 'unit_sale_price');
                $table->renameColumn('deposited_date', 'deposited_at');
                $table->renameColumn('contract_request_id', 'unit_contract_request_id');
                $table->renameColumn('agent_remark', 'requester_remark');
            });
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
            $table->renameColumn('signed_at', 'sign_date');
            $table->renameColumn('unit_sold_at', 'unit_sold_date');
            $table->renameColumn('unit_sale_price', 'unit_sold_price');
            $table->renameColumn('deposited_at', 'deposited_date');
            $table->renameColumn('unit_contract_request_id', 'contract_request_id');
            $table->renameColumn('requester_remark', 'agent_remark');

            $table->string("agent_name", 255)->default("");
            $table->unsignedTinyInteger("agent_gender")->default(1);
            $table->string("agent_phone_number", 255)->default("");       
            $table->unsignedInteger('sale_team_leader_id')->nullable(true);

            $table->foreign('sale_team_leader_id')
                  ->references('id')->on('users');
        });
    }
}
