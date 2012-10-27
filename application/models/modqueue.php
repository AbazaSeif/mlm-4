<?php
class Modqueue extends Eloquent {
	public static $table = "modqueue";

	public static $timestamps = true;

	/* Relations */
	public function user() {
		return $this->belongs_to("User");
	}

	public function mapexists($id) {
		$map = Map::find($id);
		if ($map == null) return false;
		else return true;
	}
}
?>