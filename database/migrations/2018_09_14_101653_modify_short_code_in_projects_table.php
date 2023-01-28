<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyShortCodeInProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (Schema::hasColumn('projects', 'short_code')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropUnique('projects_short_code_unique');
                $table->dropColumn('short_code');
            });
        }
        Schema::table('projects', function (Blueprint $table) {           
            $table->string('short_code',200)->unique()->nullable(true)->after('name');
        });


        //change short_code in unit_types table
        if (Schema::hasColumn('unit_types', 'short_code')) {
            Schema::table('unit_types', function (Blueprint $table) {
                $table->dropUnique('unit_types_short_code_unique');
                $table->dropColumn('short_code');
            });
        }
        Schema::table('unit_types', function (Blueprint $table) {           
            $table->string('short_code',400)->unique()->nullable(true)->after('name');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        if (Schema::hasColumn('projects', 'short_code')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropUnique('projects_short_code_unique');
                $table->dropColumn('short_code');
            });
        }
        Schema::table('projects', function (Blueprint $table) {
           $table->string("short_code", 4)->unique()->nullable(true)->after('name');           
        });

        //change short_code in unit_types table
        if (Schema::hasColumn('unit_types', 'short_code')) {
            Schema::table('unit_types', function (Blueprint $table) {
                $table->dropUnique('unit_types_short_code_unique');
                $table->dropColumn('short_code');
            });
        }
        Schema::table('unit_types', function (Blueprint $table) {
           $table->string("short_code", 4)->unique()->nullable(true)->after('name');           
        });
    }
}
