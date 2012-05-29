<?php

class Images {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("images", function($table) {
			$table->increments('id');
			$table->string("file");
			$table->string("filename");
			$table->string("type");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("images");
	}

}