<?php

class Create_Users_Auth {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('username', 20);
			$table->string('mc_username', 16);
			$table->boolean('admin');
			$table->timestamps();
		});

		Schema::create('openid', function($table) {
			$table->increments('id');
			$table->string('identity');
			$table->integer('user_id');
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('openid');
		Schema::drop('users');
	}

}