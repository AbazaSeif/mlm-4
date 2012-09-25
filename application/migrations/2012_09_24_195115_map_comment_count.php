<?php

class Map_Comment_Count {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("maps", function($table) {
			$table->integer("comment_count")->default(0);
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
			$table->drop_column("comment_count");
		});
	}

}