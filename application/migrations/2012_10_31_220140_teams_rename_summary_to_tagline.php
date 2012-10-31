<?php

class Teams_Rename_Summary_To_Tagline {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("teams", function($table) {
			$table->text("tagline");
			$table->drop_column("summary");
		});

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("teams", function($table) {
			$table->drop_column("tagline");
			$table->text("summary");
		});
	}

}