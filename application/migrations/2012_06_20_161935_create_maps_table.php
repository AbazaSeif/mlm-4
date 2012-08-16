<?php

class Create_Maps_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("maps", function($table) {
			$table->increments("id");
			$table->string("title", 128);
			$table->string("slug")->unique();
			$table->string("summary", 255);
			$table->text("description");
			$table->boolean("published")->nullable();
			$table->timestamps();
		});

		Schema::create("map_user", function($table) {
			$table->increments("id");
			// Many-to-many relationship, additional field confirmed
			$table->integer("map_id")->unsigned();
			$table->integer("user_id")->unsigned();
			$table->boolean("confirmed")->nullable();
			$table->timestamps();

			$table->foreign("map_id")->references("id")->on("maps")->on_delete("cascade")->on_update("cascade");
			$table->foreign("user_id")->references("id")->on("users")->on_delete("cascade")->on_update("cascade");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("map_user");
		Schema::drop("maps");
	}

}