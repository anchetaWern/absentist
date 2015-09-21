<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classes', function($table){
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('name');
			$table->string('class_code');
			$table->text('details');
			$table->integer('drop_absences_count');
			$table->string('days');
			$table->time('time_from');
			$table->time('time_to');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classes');
	}

}
