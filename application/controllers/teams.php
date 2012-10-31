<?php

class Teams_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("new", "leave", "kick", "edit", "edit_meta", "add_owner", "owner_invite", "invite_user", "invite", "applications", "reject_application", "accept_application", "save_application_notes", "apply", "delete_application"));
		$this->filter("before", "csrf")->on("post")->only(array("new", "leave", "kick", "edit_meta", "add_owner", "owner_invite", "invite_user", "invite", "applications", "reject_application", "accept_application", "save_application_notes", "apply", "delete_application"));
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
		$has_applied = false;
		if (Application::where_team_id($team->id)->where_user_id(Auth::user()->id)->first() != null) {
			$has_applied = true;
		}
		return View::make("teams.view", array("title" => $team->name." | Teams", "team" => $team, "is_owner" => $is_owner, "is_invited" => $is_invited, "has_applied" => $has_applied));
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
			// New team
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
			"title" => "Editing: ".e($team->name)." | Teams", "team" => $team, "owners" => $owners)
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
			$team->summary     	= Input::get("summary");
			$team->description 	= Input::get("description");
			$team->public      	= Input::get("private") == 'on' ? 0 : 1;

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

	public function get_apply($id) {
		$team = Team::with(array("users"))->find($id);
		if(!$team) {
			return Response::error('404');
		}
		if (!$team->applications_open) {
			return Response::error('404');
		}
		if($team->is_invited(Auth::user()) !== false) {
			Messages::add("error", "Can't apply to join team! You're already invited or in team");
			return Redirect::to_action("teams@view", array($team->id));
		}
		if(Application::where_team_id($team->id)->where_user_id(Auth::user()->id)->first() != null) {
			Messages::add("error", "Can't apply to join team! You've already submitted an application to join this team");
			return Redirect::to_action("teams@view", array($team->id));
		}
		return View::make("teams.apply", array("title" => "Apply to Team", "team" => $team));
	}

	public function post_apply($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		$validation_rules = array(
			"text"       	=> "required",
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// New application
			$application = new Application();
			$application->text			= Input::get("text");
			$application->team_id 		= $team->id;
			$application->user_id 		= Auth::user()->id;
			$application->save();

			Messages::add("success", "Created application!");
			return Redirect::to_action("teams@view", array($team->id));
		} else {
			return Redirect::to_action("teams@apply")->with_input()->with_errors($validation);
		}

	}

	public function get_applications($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if (strlen($team->applications_text) == 0) {
			$team->applications_text = "Please put the following things:".PHP_EOL."- Age".PHP_EOL."- Location".PHP_EOL."- Previous RFW Experience".PHP_EOL."- Why you want to join this team";
			$team->save();
		}
		$applications = Application::with(array("user"))->where_team_id($team->id)->where_null('state')->get();
		$doneapplications = Application::with(array("user"))->where_team_id($team->id)->where_not_null('state')->get();
		return View::make("teams.applications", array("title" => "Team Applications", "team" => $team, "applications" => $applications, "doneapplications" => $doneapplications));
	}

	public function post_applications($id) {
		$team = Team::find($id);
		if(!$team) {
			return Response::error('404');
		}
		if ($team->is_owner(Auth::user()) !== 1) { //make sure they are an owner of the team
			return Response::error('403');
		}
		switch (Input::get("action")) {
			case "save":
			$team->applications_text = Input::get("text");
			$team->save();
			Messages::add("success", "Team application description saved!");
			break;

			case "application_submission":
			if ($team->applications_open) {
				$team->applications_open = "0";
				Messages::add("success", "Team applications now closed!");
			}
			else {
				$team->applications_open = "1";
				Messages::add("success", "Team applications now open!");
			}
			$team->save();
			break;
		}
		return Redirect::to_action("teams@applications", array($team->id));
	}

	public function post_save_application_notes($teamid, $itemid) {
		$team = Team::find($teamid);
		if(!$team) {
			return Response::error('404');
		}
		if ($team->is_owner(Auth::user()) !== 1) { //make sure they are an owner of the team
			return Response::error('403');
		}
		$application = Application::where_team_id($team->id)->where_id($itemid)->first(); //Make sure it's in the correct team so the user must be an owner of the team
		if(!$application) {
			return Response::error('404');
		}
		$application->notes = Input::get("notes");
		$application->save();
		Messages::add("succes", "Submission Notes Saved");
		return Redirect::to_action("teams@applications", array($team->id));
	}

	public function get_accept_application($teamid, $itemid) {
		$team = Team::find($teamid);
		if(!$team) {
			return Response::error('404');
		}
		if ($team->is_owner(Auth::user()) !== 1) { //make sure they are an owner of the team
			return Response::error('403');
		}
		$application = Application::where_team_id($team->id)->where_id($itemid)->first(); //Make sure it's in the correct team so the user must be an owner of the team
		if(!$application) {
			return Response::error('404');
		}
		$user = $application->user;
		return View::make("teams.accept_application", array("title" => "Accept Team Application", "team" => $team, "application" => $application, "user" => $user));
	}

	public function post_accept_application($teamid, $itemid) {
		$team = Team::find($teamid);
		if(!$team) {
			return Response::error('404');
		}
		if ($team->is_owner(Auth::user()) !== 1) { //make sure they are an owner of the team
			return Response::error('403');
		}
		$application = Application::where_team_id($team->id)->where_id($itemid)->first(); //Make sure it's in the correct team so the user must be an owner of the team
		if(!$application) {
			return Response::error('404');
		}
		$user = $application->user;
		if($team->is_invited($user) !== false) {
			Messages::add("error", "User is already invited or in team, setting application to accepted");
			$application->state = '1';
			$application->save();
			return Redirect::to_action("teams@applications", array($team->id))->with_input();
		}
		$team->users()->attach($user->id, array("invited" => 0));
		$teamurl = URL::to_action("teams@view", array($team->id));
		$currentuser = Auth::user();
		$message = <<<EOT
You have been invited to join the team <i>**{$team->name}**</i> by {$currentuser->username}.

You can accept or deny this invite from [the team page]({$teamurl}).
EOT;
		$user->send_message("You have been invited to join the team <i>{$team->name}</i>", $message);
		$application->state = 1;
		$application->save();
		Messages::add("success", "{$user->username} has been invited to join this team. He/she must accept this invite to join the team.");
		return Redirect::to_action("teams@applications", array($team->id));
	}

	public function get_reject_application($teamid, $itemid) {
		$team = Team::find($teamid);
		if(!$team) {
			return Response::error('404');
		}
		if ($team->is_owner(Auth::user()) === null) { //make sure they are an owner of the team
			return Response::error('403');
		}
		$application = Application::where_team_id($team->id)->where_id($itemid)->first(); //Make sure it's in the correct team so the user must be an owner of the team
		if(!$application) {
			return Response::error('404');
		}
		$user = $application->user;
		return View::make("teams.reject_application", array("title" => "Reject Team Application", "team" => $team, "application" => $application, "user" => $user));
	}

	public function post_reject_application($teamid, $itemid) {
		$team = Team::find($teamid);
		if(!$team) {
			return Response::error('404');
		}
		if ($team->is_owner(Auth::user()) === null) { //make sure they are an owner of the team
			return Response::error('403');
		}
		$application = Application::where_team_id($team->id)->where_id($itemid)->first(); //Make sure it's in the correct team so the user must be an owner of the team
		if(!$application) {
			return Response::error('404');
		}
		$user = $application->user;
		if($team->is_invited($user) !== false) {
			Messages::add("error", "User is already invited or in team, setting application to accepted");
			$application->state = '1';
			$application->save();
			return Redirect::to_action("teams@applications", array($team->id))->with_input();
		}
		$reason = Input::get("reason");
		if (strlen($reason) == 0) {
			$reason = "--NO REASON GIVEN--";
		}
		$message = <<<EOT
We are sorry but your request to join the team <i>**{$team->name}**</i> has been rejected.

The reason given was:

{$reason}
EOT;
		$user->send_message("Your request to join the team <i>{$team->name}</i> has been rejected", $message);
		$application->state = "0";
		$application->save();
		Messages::add("success", "{$user->username}'s application to join this team has been rejected.");
		return Redirect::to_action("teams@applications", array($team->id));
	}

	public function get_delete_application($teamid, $itemid) {
		$team = Team::find($teamid);
		if(!$team) {
			return Response::error('404');
		}
		if ($team->is_owner(Auth::user()) === null) { //make sure they are an owner of the team
			return Response::error('403');
		}
		$application = Application::where_team_id($team->id)->where_id($itemid)->first(); //Make sure it's in the correct team so the user must be an owner of the team
		if(!$application) {
			return Response::error('404');
		}
		$user = $application->user;
		return View::make("teams.delete_application", array("title" => "Delete Team Application", "team" => $team, "application" => $application, "user" => $user));
	}

	public function post_delete_application($teamid, $itemid) {
		$team = Team::find($teamid);
		if(!$team) {
			return Response::error('404');
		}
		if ($team->is_owner(Auth::user()) === null) { //make sure they are an owner of the team
			return Response::error('403');
		}
		$application = Application::where_team_id($team->id)->where_id($itemid)->first(); //Make sure it's in the correct team so the user must be an owner of the team
		if(!$application) {
			return Response::error('404');
		}
		$user = $application->user;
		$application->delete();
		Messages::add("success", "{$user->username}'s application to join this team has been deleted.");
		return Redirect::to_action("teams@applications", array($team->id));
	}
}
?>