<?php

class Maps_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("new", "edit", "edit_meta"));
		$this->filter("before", "csrf")->on("post")->only(array("new", "edit_meta"));
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
		if(Auth::check()) {
			$is_owner = $map->is_owner(Auth::user());
		}
		if(!$map->published && (Auth::guest() || $is_owner === false && !Auth::user()->admin)) {
			return Response::error("404"); // Not yet published
		}
		$authors = $map->users()->where("confirmed", "=", 1)->with("confirmed")->get();
		return View::make("maps.view", array(
			"title" => e($map->title)." | News", "map" => $map, "authors" => $authors, "is_owner" => $is_owner
		));
	}
	/* Editing map */
	public function get_edit($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user()); // User is confirmed to be logged in
		if(!$map->published && !$is_owner) {
			return Response::error("404"); // Not yet published
		}
		
		return View::make("maps.edit", array(
			"title" => e("Edit | ".e($map->title)." | News"), "map" => $map
		));
	}
	/* Edit metadata */
	public function post_edit_meta($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user());  // User is confirmed to be logged in
		if(!$map->published && !$is_owner) {
			return Response::error("404"); // Not yet published
		}

		$validation_rules = array(
			"title"       => "required|between:3,128",
			"summary"     => "required|max:255",
			"description" => "required"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$map->title = Input::get("title");
			$map->summary = Input::get("summary");
			$map->description = IoC::resolve('HTMLPurifier')->purify(Input::get("description"));
			$map->save();
			Messages::add("success", "Map updated!");
			return Redirect::to_action("maps@edit", array($map->id));
		} else {
			return Redirect::to_action("maps@edit", array($map->id))->with_input()->with_errors($validation);
		}		
	}
}