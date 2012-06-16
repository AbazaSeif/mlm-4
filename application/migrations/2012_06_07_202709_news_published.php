<?php

class News_Published {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("news", function($table) {
			$table->boolean("published");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("news", function($table) {
			$table->drop_column("published");
		});
	}

}