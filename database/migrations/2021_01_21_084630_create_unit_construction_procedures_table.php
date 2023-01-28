<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitConstructionProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Delete the implementation of previous version 
        Schema::dropIfExists('unit_constructions');

        Schema::create('unit_construction_procedures', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();            
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('construction_procedure_id');
            $table->unsignedInteger('user_id');
            // $table->unsignedTinyInteger('progress')->default(0);
            $table->float('progress', 5, 4)->default(0);
            $table->date('estimate_completed_at')->nullable(true)->default(null);
            $table->date('actual_completed_at')->nullable(true)->default(null);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
            
            $table->unique(['unit_id', 'construction_procedure_id'], 'unit_construction_procedure_unique');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('construction_procedure_id')->references('id')->on('construction_procedures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('unit_constructions', function (Blueprint $table) {
            $table->increments('id');            
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('unit_id')->unique();
            $table->unsignedTinyInteger('foundation')->default(0);
            $table->unsignedTinyInteger('structure')->default(0);
            $table->unsignedTinyInteger('finishing')->default(0);
            $table->unsignedTinyInteger('infrastructure')->default(0);
            $table->unsignedTinyInteger('mep')->default(0);
            $table->date('actual_completed_at')->nullable(true)->default(null);
            $table->date('estimate_completed_at')->nullable(true)->default(null);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('unit_id')->references('id')->on('units');
        });
        
        // Delete the implementation of previous version 

        Schema::dropIfExists('unit_construction_procedures');
    }
}
