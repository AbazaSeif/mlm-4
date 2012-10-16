<?php
class Admin_Maps_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("edit", "view", "delete"));
	}
	// List maps
	public function get_index() {
		$maps = DB::table("maps")->order_by("id", "desc")->get(array("id", "title", "slug", "created_at", "published", "featured", "official"));
		return View::make("admin.maps.list", array("maps" => $maps, "title" => "Maps | Admin"));
	}
	// Mod view page (handles (un)publish, (un)official)
	public function get_view($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$modqueue = Modqueue::where('itemtype', '=', 'map')->where('itemid', '=', $map->id)->first();
		return View::make("admin.maps.view", array("title" => "Moderate ".e($map->title)." | Maps | Admin", "map" => $map, "modqueue" => $modqueue));
	}
	public function post_view($id) {
		$action = Input::get('action');
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}

		switch ($action)
		{
			case 'official':
			$map->official = 1;
			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "official"));
				Messages::add("success", "Map official!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;
			case 'unofficial':
			$map->official = 0;
			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "unofficial"));
				Messages::add("success", "Map made unofficial!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;

			case 'feature':
			$map->featured = 1;
			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "featured"));
				Messages::add("success", "Map featured!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;
			case 'unfeature':
			$map->featured = 0;
			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "unfeatured"));
				Messages::add("success", "Map unfeatured!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;

			case 'publish':
			$map->published = true;
			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "Approved"));
				Messages::add("success", "Map approved!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;
			case 'unpublish':
			$map->published = 0;
			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "Approval pending"));
				Messages::add("success", "Map unapproved!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;

			case 'default':
			return Response::error('404');
			break;
		}
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
			"summary"     => "required|max:140",
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
		Messages::add("success", "Map deleted!");
		return Redirect::to_action("admin.maps");
	}
}
?>