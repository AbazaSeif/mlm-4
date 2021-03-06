<?php
class Map extends Eloquent {
	public static $timestamps = true;
	public $slugfield = "title";

	// Relations
	public function users() {
		return $this->has_many_and_belongs_to("User");
	}
	public function links() {
		return $this->has_many("Map_Link");
	}
	public function ratings() {
		return $this->has_many("Map_Rating");
	}
	public function images() {
		return $this->has_many_and_belongs_to("Image", "map_images");
	}
	public function image() {
		return $this->belongs_to("Image");
	}
	public function comments() {
		return $this->has_many("Comment");
	}
	public function versions() {
		return $this->has_many("Map_Version")->order_by("id", "desc");
	}
	public function version() { // Latest version
		return $this->belongs_to("Map_Version");
	}
	public function matches() {
		return $this->has_many("Match");
	}

	/*
	 * Checks if a user is the owner of the map
	 *
	 * Returns: false if isn't
	 *          0 if invited
	 *          1 if confirmed
	 * (MAKE SURE TO USE === to get difference between invited and confirmed)
	 */
	public function is_owner($user) {
		// Doing a fluent query as it's cheaper than eloquent relation
		$is_owner = DB::table("map_user")->where_map_id($this->get_key())->where_user_id($user->get_key())->first();
		if($is_owner) {
			return (int) $is_owner->confirmed;
		} else {
			return false;
		}
	}
	/*
	 * Updates average rating
	 */
	public function update_avg_rating() {
		$this->set_attribute("avg_rating", $this->ratings()->avg("rating"));
		self::$timestamps = false; // Don't update modified time;
		$this->save();
		self::$timestamps = false;
	}

	public function update_comment_count($deletion = false) {
		if ($deletion == false) {
			$this->set_attribute("comment_count", $this->comments()->count()+1);
			self::$timestamps = false; // Don't update modified time;
			$this->save();
			self::$timestamps = false;
		}
		else {
			$this->set_attribute("comment_count", $this->comments()->count()-1);
			self::$timestamps = false; // Don't update modified time;
			$this->save();
			self::$timestamps = false;
		}
	}
}