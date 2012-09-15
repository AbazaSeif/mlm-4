<?php
class Modqueue extends Eloquent {
	public static $table = "modqueue";

	public static $timestamps = true;

	/* Relations */
	public function user() {
		return $this->belongs_to("User");
	}
}
?>