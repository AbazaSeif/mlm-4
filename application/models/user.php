<?php
class User extends Eloquent {
	public static $timestamps = true;
	
	public function openid() {
		return $this->has_many("openid");
	}
	public function profile() {
		return $this->has_one("profile");
	}
}