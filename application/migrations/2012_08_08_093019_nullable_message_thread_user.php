<?php

class Nullable_Message_Thread_User {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::query("ALTER TABLE `message_threads` CHANGE `user_id` `user_id` int(11) NULL AFTER `title`, COMMENT='';");
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::query("ALTER TABLE `message_threads` CHANGE `user_id` `user_id` int(11) NOT NULL AFTER `title`, COMMENT='';");
	}

}