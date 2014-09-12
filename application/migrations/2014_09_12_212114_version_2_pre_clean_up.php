<?php

class Version_2_Pre_Clean_Up {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop("match_user");
		Schema::drop("matches");
		Schema::drop("team_applications");
		Schema::drop("team_user");
		Schema::drop("teams");

		Schema::table("maps", function($table) {
			$table->drop_column("official");
		});

		Schema::table("users", function($table) {
			$table->drop_column("win_count");
			$table->drop_column("lose_count");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create("matches", function($table) {
			$table->increments("id");
			$table->integer("winningteam")->nullable();
			$table->timestamps();
			$table->integer("team_count");
			$table->string("mapname", 128);
			$table->integer("map_id")->unsigned()->nullable();
			$table->string("gametype");
			$table->timestamp("start_time")->nullable();
			$table->timestamp("end_time")->nullable();
			$table->string("status", 10);
			$table->text("info");
			$table->boolean("public");
			$table->boolean("invite_only");

			$table->foreign("map_id")->references("id")->on("maps")->on_delete("cascade")->on_update("cascade");
		
		});

		Schema::create("match_user", function($table) {
			$table->increments("id");
			$table->integer("match_id")->unsigned();
			$table->integer("user_id")->unsigned();
			$table->timestamps();
			$table->boolean("owner")->nullable();
			$table->integer("teamnumber")->nullable();
			$table->boolean("invited")->default('1');

			$table->foreign("match_id")->references("id")->on("matches")->on_delete("cascade")->on_update("cascade");
			$table->foreign("user_id")->references("id")->on("users")->on_delete("cascade")->on_update("cascade");
		});

		Schema::table("users", function($table) {
			$table->integer("win_count")->default(0);
			$table->integer("lose_count")->default(0);
		});

		Schema::create("teams", function($table) {
			$table->increments("id");
			$table->string("name", 128);
			$table->text("description");
			$table->boolean("public");
			$table->boolean("applications_open")->default(false);
			$table->timestamps();
			$table->text("applications_text")->nullable();
			$table->text("tagline");
		});

		Schema::create("team_user", function($table) {
			$table->increments("id");
			$table->integer("team_id")->unsigned();
			$table->integer("user_id")->unsigned();
			$table->boolean("owner")->nullable();
			$table->timestamps();
			$table->boolean("invited")->default('1');
		

			$table->foreign("team_id")->references("id")->on("teams")->on_delete("cascade")->on_update("cascade");
			$table->foreign("user_id")->references("id")->on("users")->on_delete("cascade")->on_update("cascade");

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

}