<?php

class Custom_Pages {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("pages", function($table) {
			$table->increments("id");
			$table->string("page_name", 35)->unique();
			$table->text("page_data");
			$table->timestamps();
		});			
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("pages");
	}

}