<?php
class User extends Eloquent {
	public static $timestamps = true;
	
	public function openid() {
		return $this->has_many("openid");
	}
	public function profile() {
		return $this->has_one("profile");
	}
	public function maps() {
		return $this->has_many_and_belongs_to("Map");
	}
	public function messages() {
		return $this->has_many_and_belongs_to("Message_Thread", "message_users");
	}
}