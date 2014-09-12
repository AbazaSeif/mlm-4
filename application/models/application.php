<?php
class Application extends Eloquent {
	public static $table = "team_applications";

	public static $timestamps = true;

	public function user() {
		return $this->belongs_to("User");
	}
}
?>