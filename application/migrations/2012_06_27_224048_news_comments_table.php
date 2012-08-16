<?php

class News_Comments_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("news_comments", function($table) {
			$table->increments("id");
			$table->integer("news_id")->unsigned();
			$table->integer("user_id")->unsigned();
			$table->text("source");
			$table->text("html");
			$table->timestamps();

			$table->foreign("news_id")->references("id")->on("news")->on_delete("cascade")->on_update("cascade");
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
		Schema::drop("news_comments");
	}

}