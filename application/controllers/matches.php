<?php

class Matches_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("new", "add_owner", "owner_invite", "edit_meta", "join", "leave", "teamchange", "invite_user", "set_win", "invite"));
		$this->filter("before", "csrf")->on("post")->only(array("new", "add_owner", "owner_invite", "edit_meta", "join", "leave", "teamchange", "invite_user", "set_win", "invite"));
	}

	public function get_index() {
		$matchlist = Match::with(array("users"))->paginate(10);
		return View::make("matches.home", array("title" => "Matches", "matchlist" => $matchlist));
	}

	public function get_list() {
		$matchlist = Match::with(array("users"))->paginate(10);
		return View::make("matches.list", array("title" => "Matches", "matchlist" => $matchlist));
	}

	public function get_view($id) {
		$match = Match::with(array("users", "maps"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		$map = Map::find($match->map_id);
		if(Auth::check() == false && $match->public == false) {
			return Response::error('404');
		}
		$is_owner = false;
		if(Auth::check()) {
			$is_owner = $match->is_owner(Auth::user());
		}
		$is_invited = false;
		if(Auth::check()) {
			$is_invited = $match->is_invited(Auth::user());
		}
		return View::make("matches.view", array("title" => "View Match", "match" => $match, "map" => $map, "is_owner" => $is_owner, "is_invited" => $is_invited));
	}

	public function get_new() {
		return View::make("matches.new", array("javascript" => array("matches", "edit")));
	}

	public function post_new() {
		$validation_rules = array(
			"mapname"       => "required|between:3,128",
			"maptype" 		=> 'in:'.implode(",", array_keys(Config::get("maps.types"))),
			"teamcount" 	=> "integer",
			"info"			=> "required"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// New map
			$match = new Match();
			$match->team_count	= Input::get("teamcount");
			$match->mapname 	= Input::get("mapname");
			$match->gametype	= Input::get("gametype");
			$match->info        = Input::get("info");
			$match->public      = Input::get("private") == 'on' ? 0 : 1;
			$match->invite_only = Input::get("invite") == 'on' ? 1 : 0;
			$match->status      = "planning";
			//See if we have a valid map
			$map = Map::where_title(Input::get("mapname"))->where_maptype(Input::get("gametype"))->where_teamcount(Input::get("teamcount"))->first();
			if ($map) {
				$match->map_id 	= $map->id;
			}
			$match->save();
			// Attach user
			$user = Auth::user();
			$match->users()->attach($user->id, array("teamnumber" => '0', "owner" => '1', "invited" => true));
			Messages::add("success", "Created Match!");
			return Redirect::to_action("matches@view", array($match->id));
		} else {
			return Redirect::to_action("matches@new")->with_input()->with_errors($validation);
		}
	}

	public function post_join($id) {
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		$user = Auth::user();
		$match->users()->attach($user->id, array("invited" => true, "teamnumber" => 0));
		Messages::add("success", "Joined Match");
		return Redirect::to_action("matches.view", array($match->id));
	}

	public function get_teamchange($id) {
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		return View::make("matches.teamchange", array("title" => "Change Teams", "match" => $match));
	}

	public function post_teamchange($id) {
		$teamnumber = Input::get('teamnumber');
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		$user = Auth::user();
		DB::table("match_user")->where_match_id($match->id)->where_user_id(Auth::user()->id)->update(array("teamnumber" => $teamnumber));
		Messages::add("success", "Joined Team ".$teamnumber."!");
		return Redirect::to_action("matches.view", array($match->id));
	}

	public function get_leave($id) {
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		return View::make("matches.leave", array("title" => "Leave Match", "match" => $match));
	}

	public function post_leave($id) {
		$teamnumber = Input::get('teamnumber');
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		if($match->is_owner(Auth::user()) && $match->users()->where_owner("1")->count() == 1) {
			Messages::add("error", "Please assign a new match owner before leaving");
		}
		else
		{
			DB::table("match_user")->where_match_id($match->id)->where_user_id(Auth::user()->id)->delete();
			Messages::add("success", "Left Match!");
		}
		return Redirect::to_action("matches.view", array($match->id));
	}

	/* Editing match */
	public function get_edit($id) {
		$match = Match::find($id);
		if(!$match) {
			return Response::error('404');
		}
		$map = Map::find($match->map_id);
		$is_owner = $match->is_owner(Auth::user()); // User is confirmed to be logged in
		if(!$is_owner) {
			return Response::error("404"); // Not owner
		}
		$owners = $match->users()->with("owner")->where('owner', '!=', 'null')->get();
		$statusreason = "";
		switch ($match->status) {
			case "planning":
			$statusreason = "The match has been setup but certain details may not have been set";
			break;
			case "planned":
			$statusreason = "The match has been planned and shall be happening at the allocated time";
			break;
			case "progress":
			$statusreason = "The match is currently in progress, to stop it set an end time and set a winning team";
			break;
			case "finished":
			$statusreason = "The match has finished and a winner has been set";
			break;
			case "cancelled":
			$statusreason = "The match was cancelled and so shall not be played";
			break;
		}
		$teamarray = range(1, $match->team_count);
		return View::make("matches.edit", array(
			"title" => "Edit | ".e($match->title)." | Match", "match" => $match, "owners" => $owners, "map" => $map, "teamarray" => $teamarray, "statusreason" => $statusreason)
		);
	}
	/* Edit metadata */
	public function post_edit_meta($id) {
		$match = Match::find($id);
		if(!$match) {
			return Response::error('404');
		}
		if(!$match->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not owner
		}

		$validation_rules = array(
			"mapname"       => "required|between:3,128",
			"gametype" 		=> 'in:'.implode(",", array_keys(Config::get("maps.types"))),
			"team_count"	=> "integer",
			"info"			=> "required"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$match->mapname       = Input::get("mapname");
			$match->gametype     = Input::get("gametype");
			$match->team_count   = Input::get("team_count");
			$match->info        = Input::get("info");
			$match->public      = Input::get("private") == 'on' ? 0 : 1;
			$match->invite_only = Input::get("invite") == 'on' ? 1 : 0;

			//Link with map (if we can find it)
			$map = Map::where_title(Input::get("mapname"))->where_maptype(Input::get("gametype"))->where_teamcount(Input::get("team_count"))->first();
			if ($map) {
				$match->map_id 	= $map->id;
			}
			else {
				$match->map_id = null;
			}
			$match->save();
			Messages::add("success", "Match updated!");
			return Redirect::to_action("matches@edit", array($match->id));
		} else {
			Messages::add("error", "Hold on cowboy, something just ain't right!");
			return Redirect::to_action("matches@edit", array($match->id))->with_input()->with_errors($validation);
		}		
	}
	/* Adding authors */
	public function post_add_owner($id) {
		$match = Match::find($id);
		if(!$match) {
			return Response::error('404');
		}
		if(!$match->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen(Input::get("username")) == 0) {
			Messages::add("error", "Can't add user! Please enter an username");
			return Redirect::to_action("matches@edit", array($match->id))->with_input();
		}
		// Find the user
		$user = User::where_username(Input::get("username"))->first();
		if(!$user) {
			Messages::add("error", "Can't add user! User not found");
			return Redirect::to_action("matches@edit", array($match->id))->with_input();
		}
		// Make sure user isn't already linked to the map (also filters out self)
		if($match->is_owner($user) !== false) {
			Messages::add("error", "Can't add user! User is already invited or an author");
			return Redirect::to_action("matches@edit", array($match->id))->with_input();
		}
		// All good now, create the invite
		$match->users()->attach($user->id, array("owner" => 0));
		$matchurl = URL::to_action("matches@view", array($match->id));
		$currentuser = Auth::user();
		$message = <<<EOT
You have been invited to become an owner of **{$match->title}** by {$currentuser->username}.

You can accept or deny this invite from [the match page]({$matchurl}).
EOT;
		$user->send_message("You have been invited to be an owner of match {$match->id} on map {$match->mapname}", $message);
		Messages::add("success", "{$user->username} has been invited to become an owner of this match. He/she must accept this invite to become an owner.");
		return Redirect::to_action("matches@edit", array($match->id));
	}

	public function post_invite_user($id) {
		$match = Match::find($id);
		if(!$match) {
			return Response::error('404');
		}
		if(!$match->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen(Input::get("username")) == 0) {
			Messages::add("error", "Can't add user! Please enter an username");
			return Redirect::to_action("matches@edit", array($match->id))->with_input();
		}
		// Find the user
		$user = User::where_username(Input::get("username"))->first();
		if(!$user) {
			Messages::add("error", "Can't add user! User not found");
			return Redirect::to_action("matches@edit", array($match->id))->with_input();
		}
		// Make sure user isn't already linked to the map (also filters out self)
		if($match->is_invited($user) !== false) {
			Messages::add("error", "Can't add user! User is already invited or in game");
			return Redirect::to_action("matches@edit", array($match->id))->with_input();
		}
		// All good now, create the invite
		$match->users()->attach($user->id, array("invited" => 0));
		$matchurl = URL::to_action("matches@view", array($match->id));
		$currentuser = Auth::user();
		$message = <<<EOT
You have been invited to join a match of **{$match->gametype}** on **{$match->mapname}** by {$currentuser->username}.

You can accept or deny this invite from [the match page]({$matchurl}).
EOT;
		$user->send_message("You have been invited to join a game of {$match->gametype} on map {$match->mapname}", $message);
		Messages::add("success", "{$user->username} has been invited to join this match. He/she must accept this invite to join the match.");
		return Redirect::to_action("matches@edit", array($match->id));
	}

	public function post_set_win($id) {
		$winteam = Input::get('winteam');
		$match = Match::with(array("users"))->find($id);
		if(!$match) {
			return Response::error('404');
		}
		if($winteam <= $match->team_count + 1 && $winteam != null && $winteam != 0 && $winteam != 1) {
			$match->winningteam = $winteam - 1;
			$match->status = "finished";
			if ($match->save())
			{
				Messages::add("success", "Set winning team to ".($winteam - 1)."!");
				return Redirect::to_action("matches.view", array($match->id));
			}
		 	else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("matches.view", array($match->id));
			}
		}
		else if ($winteam == 1) {
			$match->winningteam = 0;
			$match->status = "finished";
			if ($match->save())
			{
				Messages::add("success", "Set match to a draw!");
				return Redirect::to_action("matches.view", array($match->id));
			}
		 	else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("matches.view", array($match->id));
			}
		}
		else if($winteam == 0) {
			$match->winningteam = null;
			if ($match->save())
			{
				Messages::add("success", "Removed winning team!");
				return Redirect::to_action("matches.view", array($match->id));
			}
		 	else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("matches.view", array($match->id));
			}
		}
		else {
			Messages::add("error", "Team not found");
			return Redirect::to_action("matches.edit", array($match->id));
		}
	}

	public function post_owner_invite($id) {
		$match = Match::find($id);
		if(!$match) {
			return Response::error('404');
		}
		if($match->is_owner(Auth::user()) !== 0) { // User is invited to be author
			return Response::error("404");
		}

		if(Input::get("action") == "accept") {
			DB::table("match_user")->where_match_id($match->id)->where_user_id(Auth::user()->id)->update(array("owner" => true));
			Messages::add("success", "You have accepted the invite");
			return Redirect::to_action("matches@view", array($match->id));
		} elseif(Input::get("action") == "deny") {
			DB::table("match_user")->where_match_id($match->id)->where_user_id(Auth::user()->id)->update(array("owner" => null));
			Messages::add("success", "You have denied the invite");
			return Redirect::to_action("matches@view", array($match->id));
		}
	}

	public function post_invite($id) {
		$match = Match::find($id);
		if(!$match) {
			return Response::error('404');
		}
		if($match->is_invited(Auth::user()) !== 0) { // User is invited to be author
			return Response::error("404");
		}

		if(Input::get("action") == "accept") {
			DB::table("match_user")->where_match_id($match->id)->where_user_id(Auth::user()->id)->update(array("invited" => true));
			Messages::add("success", "You have accepted the invite");
			return Redirect::to_action("matches@view", array($match->id));
		} elseif(Input::get("action") == "deny") {
			DB::table("match_user")->where_match_id($match->id)->where_user_id(Auth::user()->id)->delete();
			Messages::add("success", "You have denied the invite");
			return Redirect::to_action("matches@view", array($match->id));
		}
	}
}
?>