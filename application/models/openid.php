<?php
class Openid extends Eloquent {
	public static $table = "openid";
	
	public function user() {
		$this->belongs_to("User");
	}
}