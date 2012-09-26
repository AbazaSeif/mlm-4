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
		return $this->has_many("Comment");
	}

	public function update_comment_count($deletion = false) {
		if ($deletion == false) {
			$this->set_attribute("comment_count", $this->comments()->count()+1);
			self::$timestamps = false; // Don't update modified time;
			$this->save();
			self::$timestamps = false;
		}
		else {
			$this->set_attribute("comment_count", $this->comments()->count()-1);
			self::$timestamps = false; // Don't update modified time;
			$this->save();
			self::$timestamps = false;
		}
	}
}