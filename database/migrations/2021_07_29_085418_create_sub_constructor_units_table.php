<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubConstructorUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_constructor_units', function (Blueprint $table) {
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('sub_constructor_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('unit_id')
            ->references('id')
            ->on('units');

            $table->foreign('user_id')
            ->references('id')
            ->on('users');           

            $table->foreign('sub_constructor_id')
            ->references('id')
            ->on('sub_constructors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_constructor_units');
    }
}
