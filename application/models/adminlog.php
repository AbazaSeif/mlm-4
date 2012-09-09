<?php
class Adminlog extends Eloquent {
	public static $table = "adminlog";

	public static $timestamps = true;

	public function user() {
		return $this->belongs_to("User");
	}
}