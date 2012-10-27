<?php

class Add_Modqueue_Admin_Notes {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("modqueue", function($table) {
			$table->text("admin_notes")->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("modqueue", function($table) {
			$table->drop_column("admin_notes");
		});
	}

}