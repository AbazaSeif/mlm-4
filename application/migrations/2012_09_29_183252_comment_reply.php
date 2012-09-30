<?php

class Comment_Reply {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("comments", function($table) {
			$table->integer("reply_id")->unsigned()->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("comments", function($table) {
			$table->drop_column("reply_id");
		});
	}

}