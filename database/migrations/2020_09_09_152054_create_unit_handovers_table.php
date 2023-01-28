<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitHandoversTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('unit_handovers', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('unit_handover_batch_id');
			$table->unsignedInteger('unit_id');
			$table->string('status')->nullable(true);
			$table->string('customer_name')->nullable(true);
			$table->date('last_posting_date')->nullable(true);
			$table->date('last_payment_date')->nullable(true);
			$table->smallInteger('late_payment_month')->nullable(true);
			$table->double('net_selling_price', 12, 2)->nullable(true);
			$table->double('ending_balance', 12, 2)->nullable(true);
			$table->double('total_payment', 12, 2)->nullable(true);
			$table->date('contract_signed_date')->nullable(true);
			$table->date('contract_deadline_date')->nullable(true);
			$table->smallInteger('late_deadline_month')->nullable(true);
			$table->timestamps();

			$table->foreign('unit_id')
			->references('id')->on('units')
			->onDelete('cascade');

			$table->foreign('unit_handover_batch_id')
			->references('id')->on('unit_handover_batches')
			->onDelete('cascade');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('unit_handovers');
	}
}
