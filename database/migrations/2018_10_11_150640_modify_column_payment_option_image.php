<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyColumnPaymentOptionImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('payment_option_image_url');
        });

        Schema::table('unit_types', function (Blueprint $table) {
           $table->string("payment_option_image_url", 500)->nullable(false)->default("")->after('short_code');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string("payment_option_image_url", 500)->nullable(false)->default("");    
        });

        Schema::table('unit_types', function (Blueprint $table) {
           $table->dropColumn("payment_option_image_url");    
        });
    }
}
