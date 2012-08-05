<?php

class Messaging {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::query("ALTER TABLE `users` CHANGE `id` `id` int(11) NULL AUTO_INCREMENT FIRST, COMMENT=''");

		Schema::create("message_threads", function($table) {
			$table->increments("id");
			$table->string("title", 255);
			$table->integer('user_id');
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->on_update("cascade")->on_delete("cascade");
		});
		Schema::create("message_users", function($table) {
			$table->increments("id");
			$table->integer('message_thread_id');
			$table->integer('user_id');
			$table->boolean('unread');
			$table->timestamps();

			$table->foreign('message_thread_id')->references('id')->on('message_threads')->on_update("cascade")->on_delete("cascade");
			$table->foreign('user_id')->references('id')->on('users')->on_update("cascade")->on_delete("cascade");
		});
		Schema::create("message_messages", function($table) {
			$table->increments("id");
			$table->integer('message_thread_id');
			$table->integer('user_id')->nullable();
			$table->text("message");
			$table->timestamps();

			$table->foreign('message_thread_id')->references('id')->on('message_threads')->on_update("cascade")->on_delete("cascade");
			$table->foreign('user_id')->references('id')->on('users')->on_update("cascade")->on_delete("set null");
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::query("ALTER TABLE `users` CHANGE `id` `id` int(11) AUTO_INCREMENT FIRST, COMMENT=''");

		Schema::drop("message_messages");
		Schema::drop("message_users");
		Schema::drop("message_threads");
	}

}