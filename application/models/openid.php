<?php
class Openid extends Eloquent {
	public static $table = "openid";
	
	public static $timestamps = false;
	
	public function user() {
		return $this->belongs_to("User");
	}
}