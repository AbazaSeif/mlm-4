<?php
class Team extends Eloquent {
	public static $table = "teams";

	public static $timestamps = true;

	public function users() {
		return $this->has_many_and_belongs_to("User")->with('owner', 'invited');
	}

	/*
	 * Checks if a user is the owner of the match
	 * 
	 * Returns: false if isn't
	 *          0 if invited
	 *          1 if confirmed
	 * (MAKE SURE TO USE === to get difference between invited and confirmed)
	 */
	public function is_owner($user) {
		// Doing a fluent query as it's cheaper than eloquent relation
		$is_owner = DB::table("team_user")->where_team_id($this->get_key())->where_user_id($user->get_key())->first();
		if($is_owner && ($is_owner->owner === 0 || $is_owner->owner === 1)) {
			return (int) $is_owner->owner;
		} else {
			return false;
		}
	}

	public function is_invited($user) {
		// Doing a fluent query as it's cheaper than eloquent relation
		$is_invited = DB::table("team_user")->where_team_id($this->get_key())->where_user_id($user->get_key())->first();
		if($is_invited && ($is_invited->invited === 0 || $is_invited->invited === 1)) {
			return (int) $is_invited->invited;
		} else {
			return false;
		}
	}
}
?>