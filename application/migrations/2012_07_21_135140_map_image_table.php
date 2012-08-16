<?php

class Map_Image_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("map_images", function($table) {
			$table->increments("id");
			$table->integer("map_id")->unsigned();
			$table->integer("image_id")->unsigned();
			$table->timestamps();

			$table->foreign("map_id")->references("id")->on("maps")->on_delete("cascade")->on_update("cascade");
			$table->foreign("image_id")->references("id")->on("images")->on_delete("cascade")->on_update("cascade");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("map_images");
	}

}