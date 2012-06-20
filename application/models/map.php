<?php
class Map extends Eloquent {
	public static $timestamps = true;
	public $slugfield = "title";

	public function users() {
		return $this->has_many_and_belongs_to("User");
	}
}