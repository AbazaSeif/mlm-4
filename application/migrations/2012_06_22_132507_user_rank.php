<?php

class User_Rank {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("users", function($table) {
			$table->integer("rank");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("users", function($table) {
			$table->drop_column("rank");
		});
	}

}