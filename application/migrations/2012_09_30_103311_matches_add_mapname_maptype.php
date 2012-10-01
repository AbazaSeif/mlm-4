<?php

class Matches_Add_Mapname_Maptype {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("matches", function($table) {
			$table->string("mapname", 128);
			$table->integer("map_id")->unsigned()->nullable();
			$table->string("gametype");

			$table->foreign("map_id")->references("id")->on("maps")->on_delete("cascade")->on_update("cascade");
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
			$table->drop_column("mapname");
			$table->drop_column("map_id");
			$table->drop_column("gametype");
		});
	}

}