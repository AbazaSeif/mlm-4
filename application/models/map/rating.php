<?php

class Map_Rating extends Eloquent {
	/* Relationships */
	public function map() {
		return $this->belongs_to("Map");
	}
	public function user() {
		return $this->belongs_to("User");
	}
}