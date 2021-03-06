<?php
class Admin_Maps_Controller extends Admin_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("edit", "view", "delete"));
	}
	// List maps
	public function get_index() {
		$maps = DB::table("maps")->order_by("id", "desc")->get(array("id", "title", "slug", "created_at", "published", "featured", "admin_checked"));
		return View::make("admin.maps.list", array("maps" => $maps, "title" => "Maps | Admin", "javascript" => array("admin")));
	}
	// Mod view page (handles (un)publish, (un)official)
	public function get_view($id) {
		$map = Map::find($id);
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}
		$modqueue = Modqueue::where('itemtype', '=', 'map')->where('itemid', '=', $map->id)->first();
		return View::make("admin.maps.view", array("title" => "Moderate ".e($map->title)." | Maps | Admin", "javascript" => array("admin"), "map" => $map, "modqueue" => $modqueue));
	}
	public function post_view($id) {
		$action = Input::get('action', 'default');
		$map = Map::find($id);
		$modqueue = Modqueue::find(Input::get('modqueueid'));
		if(!$map) {
			Messages::add("error", "Map not found");
			return Redirect::to_action("admin.maps");
		}

		switch ($action)
		{
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
			$map->created_at = new DateTime(); // Reset time to make it the newest.

			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "Published"));
				Messages::add("success", "Map approved!");
				if($modqueue = Modqueue::where_itemtype('map')->where_itemid($map->id)->where_type("publish")->first()) {
					$modqueue->delete();
					Event::fire("admin", array("modqueue", "delete", $modqueue->id));
				}
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;
			case 'unpublish':
			$map->published = 0;
			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "Unpublished"));
				Messages::add("success", "Map unapproved!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;

			case 'admin_check':
			$map->admin_checked = true;

			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "Admin Checked"));
				Messages::add("success", "Map marked as checked by admin!");
				if($modqueue = Modqueue::where_itemtype('map')->where_itemid($map->id)->where_type("admin_check")->first()) {
					$modqueue->delete();
					Event::fire("admin", array("modqueue", "delete", $modqueue->id));
				}
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;
			case 'admin_uncheck':
			$map->admin_checked = 0;

			if($map->save()) {
				Event::fire("admin", array("maps", "edit", $map->id, "Admin unchecked"));
				Messages::add("success", "Map marked as not checked by admin!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;

			case 'savemodqueuenotes':
			$modqueue->admin_notes = Input::get("admin_notes");
			if($modqueue->save()) {
				Messages::add("success", "Modqueue admin notes edited!");
				return Redirect::to_action("admin.maps");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.maps");
			}
			break;
			case 'deletemodqueue':
				if($modqueue->delete()) {
					Messages::add("success", "Modqueue item deleted!");
					return Redirect::to_action("admin.maps");
				} else {
					Messages::add("error", "Failed to delete");
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
		return View::make("admin.maps.form", array("title" => "Edit ".e($map->title)." | Maps | Admin", "javascript" => array("admin"), "map" => $map));
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
			"mcversion" => "max:64",
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
			$map->mcversion   = $input["mcversion"];
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
		return View::make("admin.maps.delete", array("title" => "Delete ".e($map->title)." | Maps | Admin", "javascript" => array("admin"), "map" => $map));
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