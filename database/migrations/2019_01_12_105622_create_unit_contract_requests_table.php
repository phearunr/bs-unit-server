<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_contract_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("unit_id");
            $table->unsignedInteger('unit_deposit_request_id');
            $table->string("status")->nullable(false);
            $table->string('remark',500)->nullable(true)->default('');
            $table->date("signed_at")->nullable(true);
            $table->date("start_payment_date")->nullable(true);
            $table->unsignedInteger('actioned_user_id')->nullable(true);
            $table->date('actioned_at')->nullable(true);

            $table->foreign("user_id")->references('id')->on('users');
            $table->foreign("unit_id")->references('id')->on('units');
            $table->foreign("actioned_user_id")->references('id')->on('users');
            $table->foreign("unit_deposit_request_id")->references('id')->on('unit_deposit_requests');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('unit_contract_request_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("unit_contract_request_id");
            $table->string("path");

            $table->foreign("unit_contract_request_id",'attachment_foreign_key')->references('id')->on('unit_contract_requests');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_contract_request_attachments');
        Schema::dropIfExists('unit_contract_requests');
    }
}
