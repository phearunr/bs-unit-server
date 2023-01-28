<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsV1InUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->renameColumn('contact_phone', 'phone_number');
        //     $table->renameColumn('date_of_birth', 'birthdate');
        // });
        //need to write Raw Query due to Doctrine\DBAL not support Enum type. MySQL 5.7.* support query        
        DB::statement('ALTER TABLE `users` CHANGE `contact_phone` `phone_number` VARCHAR(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
        DB::statement('ALTER TABLE `users` CHANGE `date_of_birth` `birthdate` DATE NULL DEFAULT NULL;');
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        // Schema::table('users', function (Blueprint $table) {
        //     $table->renameColumn('phone_number', 'contact_phone');
        //     $table->renameColumn('birthdate', 'date_of_birth');
        // });
        //need to write Raw Query due to Doctrine\DBAL not support Enum type. MySQL 5.7.* support query
        DB::statement('ALTER TABLE `users` CHANGE `phone_number` `contact_phone` VARCHAR(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
        DB::statement('ALTER TABLE `users` CHANGE `birthdate` `date_of_birth` DATE NULL DEFAULT NULL;');
    }
}
