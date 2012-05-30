<?php
class Openid extends Eloquent {
	public static $table = "openid";
	
	public static $timestamps = false;
	
	public function user() {
		return $this->belongs_to("User");
	}
	
	public function get_favicon() {
		$url_parts = parse_url($this->identity);
		return "http://g.etfv.co/".$url_parts['scheme']."://".$url_parts['host']."?defaulticon=bluepng";
	}
}