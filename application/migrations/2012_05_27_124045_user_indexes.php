<?php

class User_Indexes {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("users", function($table) {
			$table->unique("username");
			$table->unique("mc_username");
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
			$table->drop_unique("users_username_primary");
			$table->drop_unique("users_mc_username_primary");
		});
	}

}