<?php

class Matches_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();
	}

	public function get_index() {
		$matchlist = Match::paginate(10);
		return View::make("matches.home", array("title" => "Matches", "matchlist" => $matchlist));
	}

	public function get_list() {
		$matchlist = Match::paginate(10);
		return View::make("matches.list", array("title" => "Matches", "matchlist" => $matchlist));
	}

	public function get_view($id) {
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		return View::make("matches.view", array("title" => "View Match", "match" => $match));
	}

	public function get_new() {
		return View::make("matches.new", array("javascript" => array("matches", "edit")));
	}

	public function post_new() {
		$validation_rules = array(
			"teamcount" => "integer",
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// New map
			$match = new Match();
			$match->team_count   = Input::get("teamcount");
			$match->save();
			// Attach user as creator
			$user = Auth::user();
			if ("adduser" == true)
			{
				$match->users()->attach($user->id, array("teamnumber" => '1'));
			}
			return Redirect::to_action("matches@view", array($match->id));
		} else {
			return Redirect::to_action("matches@new")->with_input()->with_errors($validation);
		}
	}

	public function get_join($id) {
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		return View::make("matches.join", array("title" => "Join Match", "match" => $match));
	}

	public function post_join($id) {
		$teamnumber = Input::get('teamnumber');
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		$user = Auth::user();
		$match->users()->attach($user->id, array("teamnumber" => $teamnumber));
		Messages::add("success", "Joined Team ".$teamnumber."!");
		return Redirect::to_action("matches.view", array($match->id));
	}

	public function get_setwin($id) {
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		return View::make("matches.setwin", array("title" => "Set Winning Team", "match" => $match));
	}

	public function post_setwin($id) {
		$teamnumber = Input::get('teamnumber');
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		$match->winningteam = $teamnumber;
		if ($match->save())
		{
			Messages::add("success", "Set winning team to ".$teamnumber."!");
			return Redirect::to_action("matches.view", array($match->id));
		}
	 	else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("matches.view", array($match->id));
		}
	}
}
?>