<?php

class Add_Teams_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("teams", function($table) {
			$table->increments("id");
			$table->string("name", 128);
			$table->string("summary", 255);
			$table->text("description");
			$table->boolean("public");
			$table->boolean("applications_open")->default(false);
			$table->timestamps();
		});

		Schema::create("team_user", function($table) {
			$table->increments("id");
			$table->integer("team_id")->unsigned();
			$table->integer("user_id")->unsigned();
			$table->boolean("owner")->nullable();
			$table->timestamps();

			$table->foreign("team_id")->references("id")->on("teams")->on_delete("cascade")->on_update("cascade");
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
		Schema::drop("teams");
		Schema::drop("team_user");
	}

}