<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('name_km')->nullable(false);
            $table->string('name_en')->nullable(false);
            $table->string('address_line1')->nullable(true);
            $table->string('address_line2')->nullable(true);
            $table->string('contact_phone_number')->nullable(true);
            $table->string('email_address')->nullable(true);
            $table->string('website')->nullable(true);
            $table->string('tax_no')->nullable(true);
            $table->string('commercial_license_no')->nullable(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->smallInteger('company_id')->after('user_id')->unsigned()->nullable(true);

            $table->foreign('company_id')->references("id")->on('companies');
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
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
        Schema::dropIfExists('companies');
    }
}
