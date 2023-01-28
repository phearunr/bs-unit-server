<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('unit_id');
            $table->string('action',255);
            $table->string('status_action');
            $table->string('description',500)->nullable(true)->default('');
            $table->json('meta_data')->nullable(true);
            $table->timestamps();
        });

        // Schema::table('units', function (Blueprint $table) {
        //     $table->unsignedInteger('unit_action_id')->nullable(true)->after("unit_type_id");
        //     $table->foreign('unit_action_id')->references('id')->on('unit_actions');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('units', function (Blueprint $table) {
        //     $table->dropForeign('unit_action_id');
        //     $table->dropColumn('unit_action_id');  
        // });
        Schema::dropIfExists('unit_actions');
    }
}
