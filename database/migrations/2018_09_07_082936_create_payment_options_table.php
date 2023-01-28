<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_options', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger("unit_type_id");            
            $table->unsignedInteger('user_id');
            $table->string('name', 255);
            $table->unsignedTinyInteger('loan_duration')->default(0);
            $table->unsignedTinyInteger('interest')->default(0);
            $table->double("special_discount",11,2)->default(0);

            $table->softDeletes();            
            $table->timestamps();

            $table->foreign('unit_type_id')
                  ->references('id')->on('unit_types');
            $table->foreign('user_id')
                  ->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_options');
    }
}
