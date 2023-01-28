<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSaleReprentativeIdFieldToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->smallInteger("sale_representative_id")
                  ->unsigned()
                  ->nullable(true)
                  ->after("customer_city");

            $table->foreign('sale_representative_id')->references('id')->on('sale_representatives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign('contracts_sale_representative_id_foreign');   
            $table->dropColumn(['sale_representative_id']);
        });
    }
}
