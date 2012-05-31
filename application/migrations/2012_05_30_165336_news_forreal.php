<?php

class News_Forreal {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop("news");
		Schema::create("news", function($table) {
			$table->increments("id");
			$table->string("title");
			$table->string("slug")->unique();
			$table->integer("user_id")->nullable();
			$table->text("summary");
			$table->integer("image_id")->nullable();
			$table->text("content");
			$table->timestamps();

			$table->foreign("user_id")->references("id")->on("users")->on_delete("set null")->on_update("cascade");
			$table->foreign("image_id")->references("id")->on("images")->on_delete("set null")->on_update("cascade");
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
		Schema::create("news", function($table) {
			$table->increments("id");
			$table->string("title");
			$table->text("source");
			$table->text("html");
			$table->integer("user_id")->nullable();
			$table->timestamps();

			$table->foreign("user_id")->references("id")->on("users")->on_delete("set null")->on_update("cascade");
		});
	}

}