<?php
class News extends Eloquent {
	public static $table = "news";

	public static $timestamps = true;
	
	public function user() {
		return $this->belongs_to('User');
	}
}