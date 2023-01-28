<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubConstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_constructors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',200);
            $table->date('join_date')->nullable();
            $table->string('avatar', 500)->nullable();
            $table->timestamps();
        });

        Schema::create('sub_constructor_skills', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('name', 200);
            $table->string('name_km', 200);
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');   
        });
        
        Schema::create('sub_constructor_has_skills', function (Blueprint $table) {
            $table->unsignedSmallInteger('sub_constructor_skill_id');
            $table->unsignedInteger('sub_constructor_id');
            $table->timestamps();

            $table->foreign('sub_constructor_skill_id')
            ->references('id')
            ->on('sub_constructor_skills')
            ->onDelete('cascade');
            
            $table->foreign('sub_constructor_id')
            ->references('id')
            ->on('sub_constructors')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_constructor_has_skills');
        Schema::dropIfExists('sub_constructor_skills');
        Schema::dropIfExists('sub_constructors');
    }
}
