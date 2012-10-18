<?php

class Map_Add_Minecraft_Version {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("maps", function($table) {
			$table->string("mcversion", 64);
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
			$table->drop_column("mcversion");
		});
	}

}