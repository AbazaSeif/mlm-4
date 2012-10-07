<?php

class Add_Match_More_Columns {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("matches", function($table) {
			$table->timestamp("start_time")->nullable();
			$table->timestamp("end_time")->nullable();
			$table->string("status", 10);
			$table->text("info");
			$table->boolean("public");
			$table->boolean("invite_only");
		});

		Schema::table("match_user", function($table) {
			$table->boolean("invited")->default('1');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("matches", function($table) {
			$table->drop_column("start_time");
			$table->drop_column("end_time");
			$table->drop_column("status");
			$table->drop_column("info");
			$table->drop_column("public");
			$table->drop_column("invite_only");
		});

		Schema::table("match_user", function($table) {
			$table->drop_column("invited");
		});
	}

}