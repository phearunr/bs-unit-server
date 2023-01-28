<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorizeLetterUrlToSaleRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_representatives', function (Blueprint $table) {
            $table->string("authorize_letter_url",255)->nullable(true)->after("national_id_back_attachment_url");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_representatives', function (Blueprint $table) {
            $table->dropColumn("authorize_letter_url");
        });
    }
}
