<?php

class Add_Team_Applications {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("teams", function($table) {
			$table->text("applications_text")->nullable();
		});

		Schema::create("team_applications", function($table) {
			$table->increments("id");
			$table->integer("team_id")->unsigned();
			$table->integer("user_id")->unsigned();
			$table->text("text");
			$table->text("notes")->nullable();
			$table->boolean("state")->nullable();
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
		Schema::table("teams", function($table) {
			$table->drop_column("applications_text");
		});

		Schema::drop("team_applications");
	}

}