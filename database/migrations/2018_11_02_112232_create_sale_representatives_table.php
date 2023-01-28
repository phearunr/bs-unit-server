<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_representatives', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string("name", 200);
            $table->string("gender", 200)->default("Male");
            $table->date("birth_date")->default("1990-01-01");
            $table->string("national_id",200);
            $table->date('national_id_issued_date')->default("1990-01-01");
            $table->string("contact_number", 200);
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
        Schema::dropIfExists('sale_representatives');
    }
}
