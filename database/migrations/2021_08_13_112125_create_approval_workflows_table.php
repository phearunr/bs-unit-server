<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_workflows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model', 200);
            $table->unsignedInteger('user_id');
            $table->text('condition')->nullable();
            $table->string('status', 100);
            $table->string('action_true', 100);
            $table->string('action_false', 100);
            $table->tinyInteger('order')->default(1);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approval_workflows');
    }
}
