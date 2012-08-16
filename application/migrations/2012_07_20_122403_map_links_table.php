<?php

class Map_Links_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("map_links", function($table) {
			$table->increments("id");
			$table->integer("map_id")->unsigned();
			$table->text("url");
			$table->string("type", 4);
			$table->boolean("direct")->nullable();
			$table->timestamps();

			$table->foreign("map_id")->references("id")->on("maps")->on_update("cascade")->on_delete("cascade");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("map_links");
	}

}