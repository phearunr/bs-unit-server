<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsV1ToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ["", "Male", "Female"])->default("")->nullable(false)->after('contact_phone');
            $table->date('date_of_birth')->nullable(true)->after('gender');
            $table->string('avatar', 500)->default("")->nullable(false)->after('date_of_birth');
            $table->unsignedTinyInteger('identification_id')->after('avatar')->default(1);
            $table->integer("managed_by")->nullable(true)->after("identification_id");

            $table->foreign('identification_id')->references('id')->on('user_identifications');
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
            $table->dropForeign('users_identification_id_foreign');
            $table->dropColumn(['gender', 'date_of_birth', 'avatar','identification_id','managed_by']);
        });
    }
}
