<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountPromotionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_promotion_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("discount_promotion_id");
            $table->unsignedSmallInteger("unit_type_id");

            $table->foreign('discount_promotion_id')->references('id')->on('discount_promotions');
            $table->foreign('unit_type_id')->references('id')->on('unit_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_promotion_items');
    }
}
