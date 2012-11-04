<?php

class Create_Groups_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("groups", function($table) {
			$table->increments("id");
			$table->string("name", 128);
			$table->string("description", 160);
			$table->boolean("open");
			$table->timestamps();
		});

		Schema::create("group_user", function($table) {
			$table->increments("id");
			$table->integer("group_id")->unsigned();
			$table->integer("user_id")->unsigned();
			$table->boolean("owner")->nullable();
			$table->boolean("invited")->nullable();
			$table->timestamps();

			$table->foreign("group_id")->references("id")->on("groups")->on_delete("cascade")->on_update("cascade");
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
		Schema::drop("group_user");
		Schema::drop("groups");
	}

}