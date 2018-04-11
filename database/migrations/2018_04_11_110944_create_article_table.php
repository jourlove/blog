<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title')->default('');
			$table->string('keywords')->nullable()->default('');
			$table->string('description')->nullable()->default('');
			$table->text('content', 65535)->nullable();
			$table->integer('view_count')->default(0);
			$table->integer('category_id')->default(0);
			$table->string('thumb')->nullable()->default('');
			$table->string('author', 50)->nullable()->default('');
			$table->integer('create_time')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('article');
	}

}
