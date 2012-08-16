<?php

class News {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("news", function($table) {
			$table->increments("id");
			$table->string("title");
			$table->text("source");
			$table->text("html");
			$table->integer("user_id")->nullable()->unsigned();
			$table->timestamps();

			$table->foreign("user_id")->references("id")->on("users")->on_delete("set null")->on_update("cascade");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("news");
	}

}