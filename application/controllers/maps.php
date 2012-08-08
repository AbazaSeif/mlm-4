<?php

class Maps_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("new", "edit", "rate", "edit_meta", "edit_link", "delete_link", "upload_image", "delete_image"));
		$this->filter("before", "csrf")->on("post")->only(array("new", "rate", "edit_meta", "edit_link", "delete_link", "upload_image", "delete_image"));
	}

	public function get_index() {
		$maps = Map::order_by("created_at", "desc")->paginate(10);
		return View::make("maps.home", array("title" => "Maps", "maps" => $maps));
	}
	public function get_new() {
		return View::make("maps.new", array("javascript" => array("maps", "edit")));
	}
	public function post_new() {
		$validation_rules = array(
			"title"       => "required|between:3,128",
			"summary"     => "required|max:255",
			"description" => "required"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// New map
			$map = new Map();
			$map->title = Input::get("title");
			$map->summary = Input::get("summary");
			$map->description = IoC::resolve('HTMLPurifier')->purify(Input::get("description"));
			$map->save();
			// Attach user as creator
			$user = Auth::user();
			$map->users()->attach($user->id, array("confirmed" => true));
			return Redirect::to_action("maps@view", array($map->id, $map->slug));
		} else {
			return Redirect::to_action("maps@new")->with_input()->with_errors($validation);
		}
	}
	public function get_view($id, $slug = null) {
		$map = Map::find($id); // Don't really have to care about the slug
		if(!$map) {
			return Response::error('404');
		}
		if($slug != $map->slug) { // Being nice
			return Redirect::to_action("maps@view", array($id, $map->slug));
		}
		$is_owner = false;
		$rating = 0;
		if(Auth::check()) {
			$is_owner = $map->is_owner(Auth::user());
			if($ratingObj = $map->ratings()->where_user_id(Auth::user()->id)->first()) {
				$rating = $ratingObj->rating;
			}
		}
		if(!$map->published && (Auth::guest() || $is_owner === false && !Auth::user()->admin)) {
			return Response::error("404"); // Not yet published
		}
		$authors = $map->users()->where("confirmed", "=", 1)->with("confirmed")->get();
		return View::make("maps.view", array(
			"title" => e($map->title)." | Maps", "map" => $map, "authors" => $authors, "is_owner" => $is_owner, "rating" => $rating
		));
	}
	public function post_rate($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user()); // User is confirmed to be logged in
		if($is_owner) {
			return Redirect::to_action("maps@view", array($map->id, $map->slug)); // Can't rate own map
		}

		$validation_rules = array("rating" => 'required|numeric|between:1,5');
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) { 	// Skip to redirection if doesn't pass

			$ratingObj = $map->ratings()->where_user_id(Auth::user()->id)->first();
		
			if($ratingObj) { // Change vote
				$ratingObj->rating = Input::get("rating");
				$ratingObj->save();
				Messages::add("success", "Your rating has been updated");
			} else { // New vote
				$ratingObj = new Map_Rating();
				$ratingObj->user_id = Auth::user()->id;
				$ratingObj->rating = Input::get("rating");
				$map->ratings()->insert($ratingObj);
				Messages::add("success", "Your rating has been added");
			}
			$map->update_avg_rating();
		}
		return Redirect::to_action("maps@view", array($map->id, $map->slug));
	}


	/* Editing map */
	public function get_edit($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user()); // User is confirmed to be logged in
		if(!$is_owner) {
			return Response::error("404"); // Not owner
		}
		
		return View::make("maps.edit", array(
			"title" => "Edit | ".e($map->title)." | Maps", "map" => $map
		));
	}
	/* Edit metadata */
	public function post_edit_meta($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not owner
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
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$map->title       = Input::get("title");
			$map->summary     = Input::get("summary");
			$map->description = IoC::resolve('HTMLPurifier')->purify(Input::get("description"));
			$map->maptype     = Input::get("maptype");
			$map->version     = Input::get("version");
			$map->teamcount   = Input::get("teamcount");
			$map->teamsize    = Input::get("teamsize");
			$map->save();
			Messages::add("success", "Map updated!");
			return Redirect::to_action("maps@edit", array($map->id));
		} else {
			Messages::add("error", "Hold on cowboy, something just ain't right!");
			return Redirect::to_action("maps@edit", array($map->id))->with_input()->with_errors($validation);
		}		
	}
	/* Editing links */
	public function get_edit_link($id, $linkid = null) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not yet published
		}

		if($linkid) { // Editing link
			$link = $map->links()->where_id($linkid)->first();
			if(!$link) {
				return Response::error("404"); // Not map's link
			}
		} else { // New link
			$link = new Map_Link();
		}

		return View::make("maps.edit_link", array(
			"title" => "Add link | ".e($map->title)." | Maps", "map" => $map, "link" => $link
		));
	}
	public function post_edit_link($id, $linkid = null) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not yet published
		}
		if($linkid) { // Editing link
			$link = $map->links()->where_id($linkid)->first();
			if(!$link) {
				return Response::error("404"); // Not map's link
			}
		} else { // New link
			$link = new Map_Link();
		}

		$validation_rules = array(
			"url" => "required|url",
			"type" => "required|in:rar,zip,7z",
			"direct" => "in:0,1"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$link->url = Input::get("url");
			$link->type = Input::get("type");
			$link->direct = Input::get("direct");
			if(!$link->exists) {
				$map->links()->insert($link);
			} else {
				$link->save();
			}
			Messages::add("success", "Link added!");
			return Redirect::to_action("maps@edit", array($id));
		} else {
			if($linkid) {
				$redirect = Redirect::to_action("maps@edit_link", array($id, $linkid));
			} else {
				$redirect = Redirect::to_action("maps@edit_link", array($id));
			}
			return $redirect->with_input()->with_errors($validation);
		}
	}
	// Deleting links
	public function get_delete_link($id, $linkid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not yet published
		}
		$link = $map->links()->where_id($linkid)->first();
		if(!$link) {
			return Response::error("404"); // Not map's link
		}

		return View::make("maps.delete_link", array("title" => "Delete link | ".e($map->title)." | Maps", "map" => $map, "link" => $link));
	}
	public function post_delete_link($id, $linkid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not yet published
		}
		$link = $map->links()->where_id($linkid)->first();
		if(!$link) {
			return Response::error("404"); // Not map's link
		}

		if($link->delete()) {
			Messages::add("success", "Link deleted!");
		} else {
			Messages::add("error", "Failed to delete link!");
		}
		return Redirect::to_action("maps@edit", array($id));
	}
	/* Uploading images */
	public function post_upload_image($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not yet published
		}
		
		$input = Input::all();
		if(strlen($input["name"]) == 0) { // Just use the filename
			$input["name"] = $input["uploaded"]["name"];
		}
		$validation_rules = array(
			"uploaded" => "required|image|max:1000",
			"name" => "required|max:200"
		);
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$image = Image::create(array("file" => $input["uploaded"], "filename" => $input["name"], "type" => "map"));
			$map->images()->attach($image->id);
			Messages::add("success", "Image added!");
			return Redirect::to_action("maps@edit", array($id));
		} else {
			Messages::add("error", "Error while uploading the image.");
			return Redirect::to_action("maps@edit", array($id))->with_errors($validation);
		}
	}
	/* Default image */
	public function post_default_image($id, $imageid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not yet published
		}
		$image = $map->images()->where_image_id($imageid)->first();
		if(!$image) {
			return Response::error("404"); // Not map's image
		}

		$map->image_id = $image->id;
		$map->save();
		
		Messages::add("success", "Default image set");
		return Redirect::to_action("maps@edit", array($id));
	}
	/* Deleting images */
	public function get_delete_image($id, $imageid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not yet published
		}
		$image = $map->images()->where_image_id($imageid)->first();
		if(!$image) {
			return Response::error("404"); // Not map's image
		}

		return View::make("maps.delete_image", array("title" => "Delete image | ".e($map->title)." | Maps", "map" => $map, "image" => $image));
	}
	public function post_delete_image($id, $imageid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not yet published
		}
		$image = $map->images()->where_image_id($imageid)->first();
		if(!$image) {
			return Response::error("404"); // Not map's image
		}

		if($map->images()->detach($image->id)) {
			if($map->image_id == $image->id) {
				$map->image_id = null;
				$map->save();
			}
			Messages::add("success", "Image removed!");
		} else {
			Messages::add("error", "Failed to remove image!");
		}
		return Redirect::to_action("maps@edit", array($id));
	}
}