<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNavsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100)->default('');
			$table->string('alias', 50)->nullable()->default('');
			$table->string('url')->default('');
			$table->integer('order')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('navs');
	}

}
