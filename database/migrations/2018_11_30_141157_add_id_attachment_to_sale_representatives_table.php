<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdAttachmentToSaleRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_representatives', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->after("id")->default(1);
            $table->foreign('user_id')
                  ->references('id')->on('users');
            $table->string("national_id_front_attachment_url",255)->after("national_id_issued_date")->nullable(true)->default("");
            $table->string("national_id_back_attachment_url",255)->after("national_id_front_attachment_url")->nullable(true)->default("");
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
            $table->dropForeign(['user_id']);

            $table->dropColumn("user_id","national_id_front_attachment_url", "national_id_back_attachment_url");

        });
    }
}
