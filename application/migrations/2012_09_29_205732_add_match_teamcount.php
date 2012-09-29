<?php

class Add_Match_Teamcount {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("matches", function($table) {
			$table->integer("team_count");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("matches", function($table) {
			$table->drop_column("team_count");
		});
	}

}