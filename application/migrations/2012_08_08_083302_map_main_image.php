<?php

class Map_Main_Image {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("maps", function($table) {
			$table->integer("image_id")->nullable();

			$table->foreign("image_id")->references("id")->on("images")->on_update("cascade")->on_delete("set null");
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
			$table->drop_column("image_id");
		});
	}

}