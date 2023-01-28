<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentityDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id');
            $table->string('type',100);
            $table->string('reference_no', 100);
            $table->date('issue_date')->nullable(true);
            $table->date('expiration_date')->nullable(true);
            $table->json('metadata')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identity_documents');
    }
}
