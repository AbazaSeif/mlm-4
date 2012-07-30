<?php

class Map_Ratings_Tableeeee {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("map_ratings", function($table) {
			$table->increments("id");
			$table->integer("map_id");
			$table->integer("user_id");
			$table->integer("rating");
			$table->timestamps();

			$table->foreign("map_id")->references("id")->on("maps")->on_delete("cascade")->on_update("cascade");
			$table->foreign("user_id")->references("id")->on("users")->on_delete("cascade")->on_update("cascade");
		});
		Schema::table("maps", function($table) {
			$table->float("avg_rating");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("map_ratings");
		Schema::table("maps", function($table) {
			$table->drop_column("avg_rating");
		});
	}

}