<?php
class Groups_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("new", "edit"));
		$this->filter("before", "csrf")->on("post")->only(array("new", "edit"));
	}

	public function get_index() {
		return Redirect::to_action("user");
	}

	public function get_new() {
		return View::make("groups.new", array("title" => "New | Groups"));
	}

	public function post_new() {
		$validation_rules = array(
			"name"       	=> "required|between:3,128",
			"description" 	=> "required|between:3,160",
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// New group
			$group = new Group();
			$group->name			= Input::get("name");
			$group->description		= Input::get("description");
			$group->open      		= Input::get("private") == 'on' ? 0 : 1;

			$group->save();
			// Attach user
			$user = Auth::user();
			$group->users()->attach($user->id, array("owner" => '1', "invited" => true));
			Messages::add("success", "Created Group!");
			return Redirect::to_action("user");
		} else {
			return Redirect::to_action("groups@new")->with_input()->with_errors($validation);
		}
	}

	public function get_kick($id, $username) {
		$group = Group::find($id);
		if(!$group) {
			return Response::error('404');
		}
		if(!$group->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen($username) == 0) {
			Messages::add("error", "Can't find user! Please enter an username");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		// Find the user
		$user = User::where_username($username)->first();
		if(!$user) {
			Messages::add("error", "Can't find user! User not found");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		if(!$group) {
			return Response::error('404');
		}
		return View::make("groups.kick", array("title" => "Kick user from group", "group" => $group, "user" => $user));
	}

	public function post_kick($id, $username) {
		$group = Group::find($id);
		if(!$group) {
			return Response::error('404');
		}
		if(!$group->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen($username) == 0) {
			Messages::add("error", "Can't kick user! Please enter an username");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		// Find the user
		$user = User::where_username($username)->first();
		if(!$user) {
			Messages::add("error", "Can't kick user! User not found");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		if($group->is_owner($user)) { //Don't let owners kick other owners (They can speak to admins to get them removed if need be)
			Messages::add("error", "Cannot remove another owner from group");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		else
		{
			DB::table("group_user")->where_group_id($group->id)->where_user_id($user->id)->delete();
			Messages::add("success", $user->username." kicked from group!");
		}
		return Redirect::to_action("groups@edit", array($group->id));
	}

	public function get_edit($id) {
		$group = Group::find($id);
		if (!$group) {
			return Response::error('404');
		}
		if ($group->is_owner(Auth::user()) !== 1) {
			return Response::error('500');
		}
		$owners = $group->users()->where_not_null('owner')->get();
		return View::make("groups.edit", array("title" => "Edit | Groups", "group" => $group, "owners" => $owners));
	}

	public function post_edit_meta($id) {
		$group = Group::find($id);
		if(!$group) {
			return Response::error('404');
		}
		if(!$group->is_owner(Auth::user())) {
			return Response::error("404"); // Not owner
		}

		$validation_rules = array(
			"name"       	=> "required|between:3,128",	
			"description"	=> "required|between:3,160",
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$group->name       	= Input::get("name");
			$group->description 	= Input::get("description");
			$group->open      	= Input::get("private") == 'on' ? 0 : 1;

			$group->save();
			Messages::add("success", "Group updated!");
			return Redirect::to_action("users");
		} else {
			Messages::add("error", "Hold on! you forgot something!");
			return Redirect::to_action("groups@edit", array($group->id))->with_input()->with_errors($validation);
		}	
	}

	/* Adding owners */
	public function post_add_owner($id) {
		$group = Group::find($id);
		if(!$group) {
			return Response::error('404');
		}
		if(!$group->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen(Input::get("username")) == 0) {
			Messages::add("error", "Can't add user! Please enter an username");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		// Find the user
		$user = User::where_username(Input::get("username"))->first();
		if(!$user) {
			Messages::add("error", "Can't add user! User not found");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		// Make sure user isn't already linked to the map (also filters out self)
		if($group->is_owner($user) !== false) {
			Messages::add("error", "Can't add user! User is already invited or an owner");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}

		if($group->is_invited($user) === 1) {
			$group->users()->where_user_id($user->id)->first()->pivot->delete(); //So that we don't get 2 table linkages
		}
		$group->users()->attach($user->id, array("owner" => 0, "invited" => 1));
		// All good now, create the invite
		$currentuser = Auth::user();
		$message = <<<EOT
You have been invited to become an owner of the group <i>**{$group->name}**</i> by {$currentuser->username}.

You can accept or deny this invite from your profile, going to the group item and then selecting the relevant option.
EOT;
		$user->send_message("You have been invited to become an owner of the group {$group->name}", $message);
		Messages::add("success", "{$user->username} has been invited to become an owner of this group. He/she must accept this invite to become an owner.");
		return Redirect::to_action("groups@edit", array($group->id));
	}

	public function post_invite_user($id) {
		$group = Group::find($id);
		if(!$group) {
			return Response::error('404');
		}
		if(!$group->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen(Input::get("username")) == 0) {
			Messages::add("error", "Can't add user! Please enter a username");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		// Find the user
		$user = User::where_username(Input::get("username"))->first();
		if(!$user) {
			Messages::add("error", "Can't add user! User not found");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		// Make sure user isn't already linked to the map (also filters out self)
		if($group->is_invited($user) !== false) {
			Messages::add("error", "Can't add user! User is already invited or in group");
			return Redirect::to_action("groups@edit", array($group->id))->with_input();
		}
		// All good now, create the invite
		$group->users()->attach($user->id, array("invited" => 0));
		$currentuser = Auth::user();
		$message = <<<EOT
You have been invited to join the group <i>**{$group->name}**</i> by {$currentuser->username}.

You can accept or deny this invite from your profile, going to the group item and then selecting the relevant option.
EOT;
		$user->send_message("You have been invited to join the group <i>{$group->name}</i>", $message);
		Messages::add("success", "{$user->username} has been invited to join this group. He/she must accept this invite to join the group.");
		return Redirect::to_action("groups@edit", array($group->id));
	}

}
?>