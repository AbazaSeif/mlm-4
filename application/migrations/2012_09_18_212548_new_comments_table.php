<?php

class New_Comments_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		try //If this table exists, drop it. Otherwise this will give an error saying table doesn't exist but then it doesn't matter anways.
		{
			Schema::drop("news_comments");
		}
		catch (Exception $e) {}
		//Comments table
		Schema::create("comments", function($table) {
			$table->increments("id");
			$table->integer("user_id")->unsigned();
			$table->integer("map_id")->unsigned()->nullable();
			$table->integer("news_id")->unsigned()->nullable();
			$table->text("source");
			$table->text("html");
			$table->timestamps();

			$table->foreign("user_id")->references("id")->on("users")->on_delete("cascade")->on_update("cascade");
			$table->foreign("map_id")->references("id")->on("maps")->on_delete("cascade")->on_update("cascade");
			$table->foreign("news_id")->references("id")->on("news")->on_delete("cascade")->on_update("cascade");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("comments");
	}

}