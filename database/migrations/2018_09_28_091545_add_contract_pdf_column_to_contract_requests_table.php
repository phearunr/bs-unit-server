<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractPdfColumnToContractRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->date('customer1_birthdate')->nullable(true)->default('1990-01-01')->after("customer1_gender");
            $table->string('customer1_nid',100)->nullable(true)->after('customer1_birthdate');
            $table->date('customer1_nid_issued_date')->nullable(true)->default('1990-01-01')->after("customer1_nid");
            $table->date('customer2_birthdate')->nullable(true)->default('1990-01-01')->after('customer2_gender');
            $table->string('customer2_nid',100)->nullable(true)->after('customer2_birthdate');
            $table->date('customer2_nid_issued_date')->nullable(true)->default('1990-01-01')->after('customer2_nid');

            $table->string("customer_house_no",100)->nullable(true)->default("")->after("customer_phone_number2");
            $table->string("customer_street",100)->nullable(true)->default("")->after('customer_house_no');
            $table->string("customer_phum",200)->nullable(true)->default("")->after('customer_street');
            $table->string("customer_commune",200)->nullable(true)->default("")->after('customer_phum');
            $table->string("customer_district",200)->nullable(true)->default("")->after('customer_commune');
            $table->string("customer_city",200)->nullable(true)->default("")->after('customer_district');

            $table->string('unit_street',200)->nullable(true)->default("")->after('unit_code');
            $table->double('unit_land_width',8,2)->nullable(true)->default(0)->after('unit_street');
            $table->double('unit_land_length',8,2)->nullable(true)->default(0)->after('unit_land_width');
            $table->double('unit_house_width',8,2)->nullable(true)->default(0)->after('unit_land_length');
            $table->double('unit_house_length',8,2)->nullable(true)->default(0)->after('unit_house_width');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_requests', function (Blueprint $table) {
            $table->dropColumn([
                'customer1_birthdate',
                'customer1_nid',
                'customer1_nid_issued_date',
                'customer2_birthdate',
                'customer2_nid',
                'customer2_nid_issued_date',
                'customer_house_no',
                'customer_street',
                'customer_phum',
                'customer_commune',
                'customer_district',
                'customer_city',
                'unit_street',
                'unit_land_width',
                'unit_land_length',
                'unit_house_width',
                'unit_house_length'
            ]);
        });
    }
}
