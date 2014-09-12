<?php

class Webzone_Text {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//DB::query("ALTER TABLE `profiles` CHANGE `webzone` `webzone` text COLLATE 'utf8_general_ci' NOT NULL AFTER `youtube`, COMMENT='' REMOVE PARTITIONING;");
		DB::query("ALTER TABLE `profiles` CHANGE `webzone` `webzone` text COLLATE 'utf8_general_ci' NOT NULL AFTER `youtube`, COMMENT='';");
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//DB::query("ALTER TABLE `profiles` CHANGE `webzone` `webzone` varchar(200) COLLATE 'utf8_general_ci' NOT NULL AFTER `youtube`, COMMENT='' REMOVE PARTITIONING;");
		DB::query("ALTER TABLE `profiles` CHANGE `webzone` `webzone` varchar(200) COLLATE 'utf8_general_ci' NOT NULL AFTER `youtube`, COMMENT='';");
	}

}