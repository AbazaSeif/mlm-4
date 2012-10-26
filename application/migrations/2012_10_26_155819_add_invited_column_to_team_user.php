<?php

class Add_Invited_Column_To_Team_User {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("team_user", function($table) {
			$table->boolean("invited")->default('1');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("team_user", function($table) {
			$table->drop_column("invited");
		});
	}

}