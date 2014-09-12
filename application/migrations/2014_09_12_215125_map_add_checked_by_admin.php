<?php

class Map_Add_Checked_By_Admin {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("maps", function($table) {
			$table->boolean("admin_checked")->default('0');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("maps", function($table) {
			$table->dropcolumn("admin_checked");
		});
	}

}