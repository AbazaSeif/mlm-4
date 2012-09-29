<?php
class Match extends Eloquent {
	public static $table = "matches";

	public static $timestamps = true;

	public function users() {
		return $this->has_many_and_belongs_to("User")->with('teamnumber');
	}
}
?>