<?php

class Profile_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("profiles", function($table) {
			$table->integer("user_id")->primary()->unsigned(); // one-to-one with user
			$table->string("country");
			$table->string("reddit");
			$table->string("twitter");
			$table->string("youtube");
			$table->string("webzone");
			$table->timestamps();
			
			$table->foreign("user_id")->references("id")->on("users")->on_delete("cascade")->on_update("cascade");
		});

		foreach (User::all() as $user) {
			$profile = new Profile();
			$user->profile()->insert($profile);
		}
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("profiles");
	}

}