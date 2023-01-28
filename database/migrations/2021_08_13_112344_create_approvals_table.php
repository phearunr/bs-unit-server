<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type', 200);
            $table->unsignedInteger('model_id');
            $table->unsignedInteger('user_id');
            $table->string('status',100);
            $table->string('action_true', 100);
            $table->string('action_false', 100);
            $table->boolean('action')->nullable();
            $table->dateTime('actioned_at')->nullable();
            $table->string('remark', 500)->nullable();
            $table->unsignedBigInteger('next_approval_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}
