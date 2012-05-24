<?php

class User_Openid_Relationfix {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("openid", function($table) {
			$table->drop_foreign('openid_user_id_foreign');
			$table->foreign("user_id")->references("id")->on("users")->on_update("cascade")->on_delete("cascade");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("openid", function($table) {
			$table->drop_foreign('openid_user_id_foreign');
			$table->foreign("user_id")->references("id")->on("users");
		});
	}

}