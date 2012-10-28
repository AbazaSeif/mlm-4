<?php

class Teams_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("new", "leave", "kick", "edit", "edit_meta", "add_owner", "owner_invite", "invite_user", "invite"));
		$this->filter("before", "csrf")->on("post")->only(array("new", "leave", "kick", "edit_meta", "add_owner", "owner_invite", "invite_user", "invite"));
	}

	//view FAQ
	public function get_index() {
		$teams = Team::order_by("name", "desc")->paginate(10);
		return View::make("teams.list", array("title" => "Teams", "teams" => $teams));
	}

	public function get_view($id) {
		$team = Team::with(array("users"))->find($id);
		if(!$team) {
			return Response::error('404');
		}
		if(Auth::check() == false && $team->public == false) {
			return Response::error('404');
		}
		$is_owner = false;
		if(Auth::check()) {
			$is_owner = $team->is_owner(Auth::user());
		}
		$is_invited = false;
		if(Auth::check()) {
			$is_invited = $team->is_invited(Auth::user());
		}
		if ($is_owner == false && $is_invited == false && $team->public == false && Auth::user()->admin == false) {
			return Response::error("403");
		}
		return View::make("teams.view", array("title" => $team->name." | Teams", "team" => $team, "is_owner" => $is_owner, "is_invited" => $is_invited));
	}

	public function get_new() {
		return View::make("teams.new", array("javascript" => array("teams", "edit")));
	}

	public function post_new() {
		$validation_rules = array(
			"name"       	=> "required|between:3,128",
			"summary" 		=> "required|between:3,255",
			"description" 	=> "required",
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// New map
			$team = new Team();
			$team->name			= Input::get("name");
			$team->summary 		= Input::get("summary");
			$team->description	= Input::get("description");
			$team->public      	= Input::get("private") == 'on' ? 0 : 1;
			//See if we have a valid map
			$team->save();
			// Attach user
			$user = Auth::user();
			$team->users()->attach($user->id, array("owner" => '1', "invited" => true));
			Messages::add("success", "Created Team!");
			return Redirect::to_action("teams@view", array($team->id));
		} else {
			return Redirect::to_action("teams@new")->with_input()->with_errors($validation);
		}
	}

	public function get_leave($id) {
		$team = Team::with(array("users"))->find($id);
		if(!$team) {
			return Response::error('404');
		}
		return View::make("teams.leave", array("title" => "Leave Team", "team" => $team));
	}

	public function post_leave($id) {
		$team = Team::with(array("users"))->find($id);
		if(!$team) {
			return Response::error('404');
		}
		if($team->is_owner(Auth::user()) && $team->users()->where_owner("1")->count() == 1) {
			Messages::add("error", "Please assign a new team owner before leaving");
		}
		else
		{
			DB::table("team_user")->where_team_id($team->id)->where_user_id(Auth::user()->id)->delete();
			Messages::add("success", "Left Team!");
		}
		return Redirect::to_action("teams@view", array($team->id));
	}

	public function get_kick($id, $username) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if(!$team->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen($username) == 0) {
			Messages::add("error", "Can't find user! Please enter an username");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		// Find the user
		$user = User::where_username($username)->first();
		if(!$user) {
			Messages::add("error", "Can't find user! User not found");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		if(!$team) {
			return Response::error('404');
		}
		return View::make("teams.kick", array("title" => "Kick user from team", "team" => $team, "user" => $user));
	}

	public function post_kick($id, $username) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if(!$team->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen($username) == 0) {
			Messages::add("error", "Can't add user! Please enter an username");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		// Find the user
		$user = User::where_username($username)->first();
		if(!$user) {
			Messages::add("error", "Can't add user! User not found");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		if($team->is_owner($user)) { //Don't let owners kick other owners (They can speak to admins to get them removed if need be)
			Messages::add("error", "Cannot remove another owner from team");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		else
		{
			DB::table("team_user")->where_team_id($team->id)->where_user_id($user->id)->delete();
			Messages::add("success", $user->username." kicked from team!");
		}
		return Redirect::to_action("teams@edit", array($team->id));
	}

	public function get_edit($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		$is_owner = $team->is_owner(Auth::user()); // User is confirmed to be logged in
		if(!$is_owner) {
			return Response::error("404"); // Not owner
		}
		$owners = $team->users()->where_not_null('owner')->get();
		return View::make("teams.edit", array(
			"title" => "Edit | ".e($team->name)." | Teams", "team" => $team, "owners" => $owners)
		);
	}
	/* Edit metadata */
	public function post_edit_meta($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if(!$team->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not owner
		}

		$validation_rules = array(
			"name"       	=> "required|between:3,128",	
			"summary"		=> "required|between:3,255",
			"description" 	=> "required",
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$team->name       	= Input::get("name");
			$team->summary     = Input::get("summary");
			$team->description = Input::get("description");
			$team->public      = Input::get("private") == 'on' ? 0 : 1;

			$team->save();
			Messages::add("success", "Team updated!");
			return Redirect::to_action("teams@edit", array($team->id));
		} else {
			Messages::add("error", "Hold on cowboy, something just ain't right!");
			return Redirect::to_action("teams@edit", array($team->id))->with_input()->with_errors($validation);
		}		
	}

	/* Adding owners */
	public function post_add_owner($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if(!$team->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen(Input::get("username")) == 0) {
			Messages::add("error", "Can't add user! Please enter an username");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		// Find the user
		$user = User::where_username(Input::get("username"))->first();
		if(!$user) {
			Messages::add("error", "Can't add user! User not found");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		// Make sure user isn't already linked to the map (also filters out self)
		if($team->is_owner($user) !== false) {
			Messages::add("error", "Can't add user! User is already invited or an owner");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}

		if($team->is_invited($user) === 1) {
			$team->users()->where_user_id($user->id)->first()->pivot->delete(); //So that we don't get 2 table linkages
		}
		$team->users()->attach($user->id, array("owner" => 0, "invited" => 1));
		// All good now, create the invite
		$teamurl = URL::to_action("teams@view", array($team->id));
		$currentuser = Auth::user();
		$message = <<<EOT
You have been invited to become an owner of the team <i>**{$team->name}**</i> by {$currentuser->username}.

You can accept or deny this invite from [the team page]({$teamurl}).
EOT;
		$user->send_message("You have been invited to become an owner of the team {$team->name}", $message);
		Messages::add("success", "{$user->username} has been invited to become an owner of this team. He/she must accept this invite to become an owner.");
		return Redirect::to_action("teams@edit", array($team->id));
	}

	public function post_owner_invite($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if($team->is_owner(Auth::user()) !== 0) { // User is invited to be author
			return Response::error("404");
		}

		if(Input::get("action") == "accept") {
			DB::table("team_user")->where_team_id($team->id)->where_user_id(Auth::user()->id)->update(array("owner" => true));
			Messages::add("success", "You have accepted the invite");
			return Redirect::to_action("teams@view", array($team->id));
		} elseif(Input::get("action") == "deny") {
			DB::table("team_user")->where_team_id($team->id)->where_user_id(Auth::user()->id)->update(array("owner" => null));
			Messages::add("success", "You have denied the invite");
			return Redirect::to_action("teams@view", array($team->id));
		}
	}

	public function post_invite_user($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if(!$team->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen(Input::get("username")) == 0) {
			Messages::add("error", "Can't add user! Please enter an username");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		// Find the user
		$user = User::where_username(Input::get("username"))->first();
		if(!$user) {
			Messages::add("error", "Can't add user! User not found");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		// Make sure user isn't already linked to the map (also filters out self)
		if($team->is_invited($user) !== false) {
			Messages::add("error", "Can't add user! User is already invited or in team");
			return Redirect::to_action("teams@edit", array($team->id))->with_input();
		}
		// All good now, create the invite
		$team->users()->attach($user->id, array("invited" => 0));
		$teamurl = URL::to_action("teams@view", array($team->id));
		$currentuser = Auth::user();
		$message = <<<EOT
You have been invited to join the team <i>**{$team->name}**</i> by {$currentuser->username}.

You can accept or deny this invite from [the team page]({$teamurl}).
EOT;
		$user->send_message("You have been invited to join the team <i>{$team->name}</i>", $message);
		Messages::add("success", "{$user->username} has been invited to join this team. He/she must accept this invite to join the team.");
		return Redirect::to_action("teams@edit", array($team->id));
	}

	public function post_invite($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if($team->is_invited(Auth::user()) !== 0) { // User is invited to be author
			return Response::error("404");
		}

		if(Input::get("action") == "accept") {
			DB::table("team_user")->where_team_id($team->id)->where_user_id(Auth::user()->id)->update(array("invited" => true));
			Messages::add("success", "You have accepted the invite");
			return Redirect::to_action("teams@view", array($team->id));
		} elseif(Input::get("action") == "deny") {
			DB::table("team_user")->where_team_id($team->id)->where_user_id(Auth::user()->id)->delete();
			Messages::add("success", "You have denied the invite");
			return Redirect::to_action("teams@view", array($team->id));
		}
	}

}
?>