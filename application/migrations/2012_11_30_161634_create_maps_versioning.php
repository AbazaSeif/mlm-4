<?php

class Create_Maps_Versioning {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("map_versions", function($table) {
			$table->increments("id");
			$table->integer("map_id")->unsigned();
			$table->string("version", 64);
			$table->string("version_slug", 96);
			$table->text("changelog");
			$table->boolean("uploaded");
			$table->boolean("autoref");
			$table->timestamps();

			$table->unique(array("map_id", "version_slug"));
			$table->foreign("map_id")->references("id")->on("maps")->on_update("cascade")->on_delete("cascade");
		});
		Schema::table("maps", function($table) {
			$table->integer("version_id")->unsigned()->nullable();
			$table->drop_column("version");

			$table->foreign("version_id")->references("id")->on("map_versions")->on_update("cascade")->on_delete("set null");
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
			$table->string("version", 64);
			$table->drop_column("version_id"); // Data loss wooooooooooooo!
		});
		Schema::drop("map_versions");
	}

}