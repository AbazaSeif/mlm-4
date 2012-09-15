<?php
class Admin_Maps_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("edit", "publish", "feature", "official", "delete"));
	}
	// List maps
	public function get_index() {
		$maps = DB::table("maps")->order_by("id", "desc")->get(array("id", "title", "slug", "created_at", "published", "featured", "official"));
		return View::make("admin.maps.list", array("maps" => $maps, "title" => "Maps | Admin"));
	}
	// Edit
	public function get_edit($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		return View::make("admin.maps.form", array("title" => "Edit ".e($map->title)." | Maps | Admin", "map" => $map));
	}
	public function post_edit($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$validation_rules = array(
			"title"       => "required|between:3,128",
			"summary"     => "required|max:255",
			"description" => "required",

			"maptype" => 'in:'.implode(",", array_keys(Config::get("maps.types"))),
			"version" => "max:64",
			"teamcount" => "integer",
			"teamsize" => "integer"
		);
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$map->title       = $input["title"];
			$map->summary     = $input["summary"];
			$map->description = IoC::resolve('HTMLPurifier')->purify($input["description"]);
			$map->maptype     = $input["maptype"];
			$map->version     = $input["version"];
			$map->teamcount   = $input["teamcount"];
			$map->teamsize    = $input["teamsize"];
			$changed = array_keys($map->get_dirty());
			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, $changed));
				//Check if on modqueue list
				$modqueue = Modqueue::where('itemtype', '=', 'map')->where('itemid', '=', $id)->first();
				if ($modqueue)
				{
					Messages::add("important", "Found item on modqueue");
					return Redirect::to_action("admin.modqueue@view", array('id' => $modqueue->id));
				}
				Messages::add("success", "Map updated!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps@edit")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.maps@edit", array($id))->with_input()->with_errors($validation);
		}
	}
	// Publish
	public function get_publish($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		return View::make("admin.maps.publish", array("title" => "Approve ".e($map->title)." | Maps | Admin", "map" => $map));
	}
	public function post_publish($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$map->published = true;
		if($map->save()) {
			Event::fire("admin", array("maps", "edit", $map->id, "Approved"));
			//Check if on modqueue list
			$modqueue = Modqueue::where('itemtype', '=', 'map')->where('itemid', '=', $id)->first();
			if ($modqueue)
			{
				Messages::add("important", "Found item on modqueue");
				return Redirect::to_action("admin.modqueue@view", array('id' => $modqueue->id));
			}
			Messages::add("success", "Map approved!");
			return Redirect::to_action("admin.maps");
		} else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("admin.maps");
		}
	}
	public function get_unpublish($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		return View::make("admin.maps.unpublish", array("title" => "UnFeature ".e($map->title)." | Maps | Admin", "map" => $map));
	}
	public function post_unpublish($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$map->published = false;
		if($map->save()) {
			Event::fire("admin", array("maps", "edit", $map->id, "Approval pending"));
			//Check if on modqueue list
			$modqueue = Modqueue::where('itemtype', '=', 'map')->where('itemid', '=', $id)->first();
			if ($modqueue)
			{
				Messages::add("important", "Found item on modqueue");
				return Redirect::to_action("admin.modqueue@view", array('id' => $modqueue->id));
			}
			Messages::add("success", "Map revoked!");
			return Redirect::to_action("admin.maps");
		} else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("admin.maps");
		}
	}
	// Feature
	public function get_feature($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		return View::make("admin.maps.feature", array("title" => "Feature ".e($map->title)." | Maps | Admin", "map" => $map));
	}
	public function post_feature($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$map->featured = 1;
		if($map->save()) {
			Event::fire("admin", array("maps", "edit", $map->id, "featured"));
			Messages::add("success", "Map featured!");
			return Redirect::to_action("admin.maps");
		} else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("admin.maps");
		}
	}
	public function get_unfeature($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		return View::make("admin.maps.unfeature", array("title" => "UnFeature ".e($map->title)." | Maps | Admin", "map" => $map));
	}
	public function post_unfeature($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$map->featured = 0;
		if($map->save()) {
			Event::fire("admin", array("maps", "edit", $map->id, "unfeatured"));
			Messages::add("success", "Map unfeatured!");
			return Redirect::to_action("admin.maps");
		} else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("admin.maps");
		}
	}
	// Official
		public function get_official($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		return View::make("admin.maps.official", array("title" => "Official ".e($map->title)." | Maps | Admin", "map" => $map));
	}
	public function post_official($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$map->official = 1;
		if($map->save()) {
			Event::fire("admin", array("maps", "edit", $map->id, "official"));
			Messages::add("success", "Map made official!");
			return Redirect::to_action("admin.maps");
		} else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("admin.maps");
		}
	}
	public function get_unofficial($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		return View::make("admin.maps.unofficial", array("title" => "UnOfficial ".e($map->title)." | Maps | Admin", "map" => $map));
	}
	public function post_unofficial($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$map->official = 0;
		if($map->save()) {
			Event::fire("admin", array("maps", "edit", $map->id, "unofficial"));
			Messages::add("success", "Map made unofficial!");
			return Redirect::to_action("admin.maps");
		} else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("admin.maps");
		}
	}
	// Delete form. DO NOT EVER DO ACTUAL DELETEION IN A GET METHOD
	public function get_delete($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		return View::make("admin.maps.delete", array("title" => "Delete ".e($map->title)." | Maps | Admin", "map" => $map));
	}
	// Deletion
	public function post_delete($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$map->delete();
		Event::fire("admin", array("map", "delete", $map->id));
		//Check if on modqueue list
		$modqueue = Modqueue::where('itemtype', '=', 'map')->where('itemid', '=', $id)->first();
		if ($modqueue)
		{
			Messages::add("important", "Found item on modqueue");
			return Redirect::to_action("admin.modqueue@view", array('id' => $modqueue->id));
		}
		Messages::add("success", "Map deleted!");
		return Redirect::to_action("admin.maps");
	}
}
?>