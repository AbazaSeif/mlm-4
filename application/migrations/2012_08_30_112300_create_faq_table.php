<?php

class Create_Faq_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("faq", function($table) {
			$table->increments("id");
			$table->string("question", 128);
			$table->text("answer");
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
		Schema::drop("faq");
	}

}