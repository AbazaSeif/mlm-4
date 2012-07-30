<?php

class Map_Link extends Eloquent {
	/* Relationships */
	public function maps() {
		return $this->belongs_to("Map");
	}


	public function get_favicon() {
		$url_parts = parse_url($this->url);
		return "http://g.etfv.co/".$url_parts['scheme']."://".$url_parts['host']."?defaulticon=bluepng";
	}
}