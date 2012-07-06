<?php
class News extends Eloquent {
	public static $table = "news";

	public static $timestamps = true;
	public $slugfield = "title";

	/* Relations */
	public function user() {
		return $this->belongs_to("User");
	}
	public function image() {
		return $this->belongs_to("Image");
	}
	public function comments() {
		return $this->has_many("News_Comment");
	}

	public function update_comment_count() {
		$this->set_attribute("comment_count", $this->comments()->count());
		self::$timestamps = false; // Don't update modified time;
		$this->save();
		self::$timestamps = false;
	}
}