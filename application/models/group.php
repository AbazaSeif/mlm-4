<?php
class Group extends Eloquent {
	public static $table = "groups";

	public static $timestamps = true;

	public function users() {
		return $this->has_many_and_belongs_to("User")->with('owner', 'invited');
	}

	/*
	 * Checks if a user is the owner of the group
	 * 
	 * Returns: false if isn't
	 *          0 if invited
	 *          1 if confirmed
	 * (MAKE SURE TO USE === to get difference between invited and confirmed)
	 */
	public function is_owner($user) {
		// Doing a fluent query as it's cheaper than eloquent relation
		$is_owner = DB::table("group_user")->where_group_id($this->get_key())->where_user_id($user->get_key())->first();
		if($is_owner && ($is_owner->owner === 0 || $is_owner->owner === 1)) {
			return (int) $is_owner->owner;
		} else {
			return false;
		}
	}

	public function is_invited($user) {
		// Doing a fluent query as it's cheaper than eloquent relation
		$is_invited = DB::table("group_user")->where_group_id($this->get_key())->where_user_id($user->get_key())->first();
		if($is_invited && ($is_invited->invited === 0 || $is_invited->invited === 1)) {
			return (int) $is_invited->invited;
		} else {
			return false;
		}
	}
}
?>