<?php

class Image extends Eloquent {
	public static $timestamps = false;
	
	public static function create($arguments) {
		$handle = new upload($arguments["file"]);
		if($handle->uploaded) {
			$extension = $handle->image_src_type;
			$newobj = parent::create(array("filename" => $arguments["filename"], "type" => $arguments["type"]));
			$localname = md5($newobj->id);
			$newobj->file = "{$localname}.{$extension}";
			$newobj->save();
			
			// Original
			$handle->file_new_name_body = $localname;
			$handle->process(path("public")."/images/uploads/o/");
			// Large (600x300, cropped)
			$handle->file_new_name_body = $localname;
			$handle->image_resize = true;
			$handle->image_x = 600;
			$handle->image_y = 300;
			$handle->image_ratio_crop = true;
			$handle->process(path("public")."/images/uploads/l/");
			// Medium (170x110, cropped)
			$handle->file_new_name_body = $localname;
			$handle->image_resize = true;
			$handle->image_x = 170;
			$handle->image_y = 110;
			$handle->image_ratio_crop = true;
			$handle->process(path("public")."/images/uploads/m/");
			// Small (150x150, upto)
			$handle->file_new_name_body = $localname;
			$handle->image_resize = true;
			$handle->image_x = 150;
			$handle->image_y = 150;
			$handle->image_ratio = true;
			$handle->process(path("public")."/images/uploads/s/");
			
			return $newobj;
		} else {
			return null;
		}
	}
	
	public function get_file_original() {
		return "images/uploads/o/".$this->file;
	}
	public function get_file_large() {
		return "images/uploads/l/".$this->file;
	}
	public function get_file_medium() {
		return "images/uploads/m/".$this->file;
	}
	public function get_file_small() {
		return "images/uploads/s/".$this->file;
	}
	public function to_array() {
		$array = parent::to_array();
		$array["file_small"] = $this->file_small;
		$array["file_medium"] = $this->file_medium;
		$array["file_large"] = $this->file_large;
		$array["file_original"] = $this->file_original;
		return $array;
	}
}