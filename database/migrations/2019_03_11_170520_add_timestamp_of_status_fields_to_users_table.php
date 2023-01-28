<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampOfStatusFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('activator_id')->after('active')->nullable(true);
            $table->dateTime('activated_at')->after('activator_id')->nullable(true);

            $table->unsignedInteger('verifier_id')->after('verified')->nullable(true);
            $table->dateTime('verified_at')->after('verifier_id')->nullable(true);

            $table->foreign('activator_id')->references('id')->on('users');
            $table->foreign('verifier_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_activator_id_foreign');
            $table->dropForeign('users_verifier_id_foreign');
            $table->dropColumn(['activator_id', 'activated_at', 'verifier_id', 'verified_at']);
        });
    }
}
