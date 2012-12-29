<?php
class Map_Version extends Eloquent {
	/* Relationships */
	public function map() {
		return $this->belongs_to("Map");
	}

	public function save() {
		// Slug generation
		// Due to need to also check map_id it's seperate from event's way
		if(!$this->version_slug) {
			// Try to find an un-used slug
			$i = 0;
			$slug;
			while(true) {
				$slug = Str::limit(Str::slug(str_replace(".", "-", $this->version)), 96-(strlen($i)+1), "");
				if($i > 0) {
					$slug .= "-".$i;
				}
				if(!DB::table($this->table())->where_map_id_and_version_slug($this->map_id, $slug)->first()) {
					break;
				}
				$i++;
			}
			$this->version_slug = $slug;
		}

		parent::save();
	}
}