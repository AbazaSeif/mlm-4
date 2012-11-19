<?php

class Add_Image_Ext_Field {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("images", function($table) {
			$table->string("ext", 4);
		});

		$images = Image::all();
		foreach ($images as $image) {
			$imageparts = explode(".", $image->file); // There will never be dots in filename so it will be 2 parts
			$image->file = $imageparts[0];
			$image->ext = $imageparts[1];
			$image->save();
		}
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		$images = Image::all();
		foreach ($images as $image) {
			$imagefile = explode(".", array($image->file, $image->ext)); // There will never be dots in filename so it will be 2 parts
			$image->file = $imagefile;
			$image->save();
		}

		Schema::table("images", function($table) {
			$table->drop_column("ext");
		});
	}

}