<?php
class Admin_Teams_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("edit", "delete"));
	}

	public function get_index() {
		$teams = Team::get();
		return View::make("admin.teams.list", array("teams" => $teams, "title" => "Teams | Admin", "javascript" => array("admin")));
	}

	// Edit
	public function get_edit($id) {
		$team = Team::find($id);
		if(!$team) {
			Messages::add("error", "Team not found");
			return Redirect::to_action("admin.teams");
		}
		return View::make("admin.teams.edit", array("title" => "Edit ".e($team->name)." | Teams | Admin", "javascript" => array("admin"), "team" => $team));
	}
	public function post_edit($id) {
		$team = Team::find($id);
		if(!$team) {
			Messages::add("error", "Team not found");
			return Redirect::to_action("admin.teams");
		}
		$validation_rules = array(
			"name"       	=> "required|between:3,128",	
			"summary"		=> "required|between:3,255",
			"description" 	=> "required"
		);
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$team->name       	= Input::get("name");
			$team->summary     	= Input::get("summary");
			$team->description 	= Input::get("description");
			$team->public      	= Input::get("private") == "on" ? 0 : 1;

			$team->save();
			$changed = array_keys($team->get_dirty());
			if($team->save()) {
				Event::fire("admin", array("team", "edit", $team->id, $changed));
				Messages::add("success", "Team updated!");
				return Redirect::to_action("admin.teams");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.teams@edit")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.teams@edit", array($id))->with_input()->with_errors($validation);
		}
	}

	// Delete form. DO NOT EVER DO ACTUAL DELETEION IN A GET METHOD
	public function get_delete($id) {
		$team = Team::find($id);
		if(!$team) {
			Messages::add("error", "Team not found");
			return Redirect::to_action("admin.teams");
		}
		return View::make("admin.teams.delete", array("title" => "Delete ".e($team->title)." | Teams | Admin", "javascript" => array("admin"), "team" => $team));
	}
	// Deletion
	public function post_delete($id) {
		$team = Team::find($id);
		if(!$team) {
			Messages::add("error", "Team not found");
			return Redirect::to_action("admin.teams");
		}
		$team->delete();
		Event::fire("admin", array("team", "delete", $team->id));
		Messages::add("success", "Team deleted!");
		return Redirect::to_action("admin.teams");
	}
}
?>