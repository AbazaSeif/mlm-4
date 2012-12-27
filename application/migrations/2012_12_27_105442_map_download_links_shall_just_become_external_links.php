<?php

class Map_Download_Links_Shall_Just_Become_External_Links {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("map_links", function($table) {
			$table->string("title");
			$table->drop_column("type");
			$table->drop_column("direct");
		});
		$counters = array();
		foreach (Map_Link::all() as $link) {
			if(!isset($counters[$link->map_id])) {
				$counters[$link->map_id] = 0;
			}
			$counters[$link->map_id]++;
			$link->title = "Download link #".$counters[$link->map_id];
			$link->save();
		}
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("map_links", function($table) {
			$table->drop_column("title");
			$table->string("type", 4);
			$table->boolean("direct");
		});
	}

}