<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWebConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('web_config', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('var_name')->default('')->comment('//变量名称,代表标题');
			$table->text('content', 65535)->nullable()->comment('//内容');
			$table->string('title')->nullable()->default('')->comment('//配置项标题');
			$table->string('tips')->nullable()->default('')->comment('//说明');
			$table->string('content_type', 50)->nullable()->default('')->comment('//内容的类型');
			$table->string('content_value')->nullable()->default('')->comment('//内容的值有哪些选项');
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
		Schema::drop('web_config');
	}

}
