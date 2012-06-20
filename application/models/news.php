<?php
class News extends Eloquent {
	public static $table = "news";

	public static $timestamps = true;
	public $slugfield = "title";

	public function user() {
		return $this->belongs_to("User");
	}
	public function image() {
		return $this->belongs_to("Image");
	}
}