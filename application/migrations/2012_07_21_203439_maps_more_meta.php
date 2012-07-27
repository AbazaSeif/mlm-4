<?php

class Maps_More_Meta {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("maps", function($table) {
			$table->string("maptype");
			$table->integer("teamcount")->nullable();
			$table->integer("teamsize")->nullable();
			$table->string("version", 64);
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
			$table->drop_column(array("maptype", "teamcount", "teamsize", "version"));
		});
	}

}