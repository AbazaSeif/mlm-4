<?php

class Add_Owner_To_Match_User {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("match_user", function($table) {
			$table->drop_column("teamnumber");
		});

		Schema::table("match_user", function($table) {
			$table->boolean("owner")->nullable();
			$table->integer("teamnumber")->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("match_user", function($table) {
			$table->drop_column("owner");
			$table->drop_column("teamnumber");
		});

		Schema::table("match_user", function($table) {
			$table->integer("teamnumber");
		});
	}

}