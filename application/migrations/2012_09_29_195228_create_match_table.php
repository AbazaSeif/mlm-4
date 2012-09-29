<?php

class Create_Match_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("matches", function($table) {
			$table->increments("id");
			$table->integer("winningteam")->nullable();
			$table->timestamps();
		});

		Schema::create("match_user", function($table) {
			$table->increments("id");
			$table->integer("match_id")->unsigned();
			$table->integer("user_id")->unsigned();
			$table->integer("teamnumber")->unsigned();
			$table->timestamps();

			$table->foreign("match_id")->references("id")->on("matches")->on_delete("cascade")->on_update("cascade");
			$table->foreign("user_id")->references("id")->on("users")->on_delete("cascade")->on_update("cascade");
		});

		Schema::table("users", function($table) {
			$table->integer("win_count")->default(0);
			$table->integer("lose_count")->default(0);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("matches");
		Schema::drop("match_user");

		Schema::table("users", function($table) {
			$table->drop_column("win_count");
			$table->drop_column("lose_count");
		});
	}

}