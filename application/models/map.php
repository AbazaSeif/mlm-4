<?php
class Map extends Eloquent {
	public static $timestamps = true;
	public $slugfield = "title";

	// Relations
	public function users() {
		return $this->has_many_and_belongs_to("User");
	}

	/*
	 * Checks if a user is the owner of the map
	 * 
	 * Returns: false if isn't
	 *          0 if invited
	 *          1 if confirmed
	 * (MAKE SURE TO USE ===)
	 */
	public function is_owner($user) {
		$is_owner = $this->users()->where_user_id($user->get_key())->with("confirmed")->first();
		if($is_owner) {
			return (int) $is_owner->pivot->confirmed;
		} else {
			return false;
		}
	}
}