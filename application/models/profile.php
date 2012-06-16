<?php
class Profile extends Eloquent {
	public static $key = "user_id";

	public function user() {
		$this->belongs_to("user");
	}
	
}