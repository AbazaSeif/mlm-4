<?php

class Maps_Add_Official {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("maps", function($table) {
			$table->boolean("official")->default(false);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::$table("maps", function($table) {
			$table->drop_column("official");
		});
	}

}