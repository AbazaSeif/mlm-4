<?php

class Add_News_Comments_Count {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("news", function($table) {
			$table->integer("comment_count");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("news", function($table) {
			$table->drop_column("comment_count");
		});
	}

}