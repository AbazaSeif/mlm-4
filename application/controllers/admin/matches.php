<?php
class Admin_Matches_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("edit", "delete"));
	}

	public function get_index() {
		$matches = Match::get();
		return View::make("admin.matches.list", array("matches" => $matches, "title" => "Matches | Admin"));
	}

	// Edit
	public function get_edit($id) {
		$match = Match::find($id);
		if(!$match) {
			Messages::add("error", "Match not found");
			return Redirect::to_action("admin.matches");
		}
		$map = Map::find($match->map_id);
		$teamarray = range(1, $match->team_count);
		return View::make("admin.matches.edit", array("title" => "Edit ".e($match->id)." | Matches | Admin", "match" => $match, "map" => $map, "teamarray" => $teamarray));
	}
	public function post_edit($id) {
		$match = Match::find($id);
		if(!$match) {
			Messages::add("error", "Match not found");
			return Redirect::to_action("admin.matches");
		}
		$validation_rules = array(
			"mapname"       => "required|between:3,128",
			"gametype" => 'in:'.implode(",", array_keys(Config::get("maps.types"))),
			"team_count" => "integer",
			"info"			=> "required"
		);
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$match->mapname       = Input::get("mapname");
			$match->gametype     = Input::get("gametype");
			$match->team_count   = Input::get("team_count");
			$match->info        = Input::get("info");
			$match->public      = Input::get("private") == 'on' ? 0 : 1;
			$match->invite_only = Input::get("invite") == 'on' ? 1 : 0;
			$match->winningteam = Input::get('winteam') == 0 ? null : Input::get('winteam') - 1;
			
			$changed = array_keys($match->get_dirty());
			if($match->save()) {
				Event::fire("admin", array("match", "edit", $match->id, $changed));
				Messages::add("success", "Match updated!");
				return Redirect::to_action("admin.matches");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.matches@edit")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.matches@edit", array($id))->with_input()->with_errors($validation);
		}
	}

	// Delete form. DO NOT EVER DO ACTUAL DELETEION IN A GET METHOD
	public function get_delete($id) {
		$match = Match::find($id);
		if(!$match) {
			Messages::add("error", "Match not found");
			return Redirect::to_action("admin.matches");
		}
		return View::make("admin.matches.delete", array("title" => "Delete ".e($match->id)." | Matches | Admin", "match" => $match));
	}
	// Deletion
	public function post_delete($id) {
		$match = Match::find($id);
		if(!$match) {
			Messages::add("error", "Match not found");
			return Redirect::to_action("admin.matches");
		}
		$match->delete();
		Event::fire("admin", array("match", "delete", $match->id));
		Messages::add("success", "Match deleted!");
		return Redirect::to_action("admin.matches");
	}
}
?>