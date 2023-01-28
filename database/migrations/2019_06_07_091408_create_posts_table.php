<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreatePostsTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('id');     
			$table->string('name');
			$table->string('description')
			->nullable(true)
			->default("");
			$table->string('slug');
			$table->boolean('default')->default(false);
			$table->timestamps();

			NestedSet::columns($table);
		});

		Schema::create('posts', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->text('title');
			$table->string('short_description', 500);
			$table->text('content');
			$table->string('featured_image_url')->nullable(true);
			$table->string('status');
			$table->string('type');
			$table->dateTime('published_at');
			$table->timestamps();
		});

		Schema::create('category_post', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('post_id');
			$table->unsignedInteger('category_id');

			$table->foreign('post_id')->references('id')->on('posts');
			$table->foreign('category_id')->references('id')->on('categories');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('category_post');        
		Schema::dropIfExists('posts');
		Schema::dropIfExists('categories');
	}
}
