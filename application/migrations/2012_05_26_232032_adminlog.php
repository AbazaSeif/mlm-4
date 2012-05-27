<?php

class Adminlog {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("adminlog", function($table) {
			$table->increments("id");
			$table->integer("user_id")->nullable();
			$table->string("module");
			$table->string("action");
			$table->integer("target")->nullable();
			$table->text("text");
			$table->timestamps();

			$table->foreign("user_id")->references("id")->on("users")->on_delete('set null')->on_update("cascade");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("adminlog");
	}

}