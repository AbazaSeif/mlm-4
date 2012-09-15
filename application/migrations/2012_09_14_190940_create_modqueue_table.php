<?php

class Create_Modqueue_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("modqueue", function($table) {
			$table->increments("id");
			$table->integer("user_id")->unsigned();
			$table->string("type", 16);
			$table->string("itemtype", 16);
			$table->integer("itemid")->unsigned();
			$table->text("data")->nullable();
			$table->timestamps();

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
		Schema::drop("modqueue");
	}

}