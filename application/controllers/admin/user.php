<?php
class Admin_User_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only("edit");
	}
	
	// Listing users
	public function get_index() {
		$users = DB::table("users")->get(array("id", "username", "mc_username", "created_at", "admin","rank"));
		return View::make('admin.users.list', array("users" => $users, "title" => "Users | Admin", "javascript" => array("admin")));
	}

	// Edit form
	public function get_edit($id) {
		$user = User::find($id); // Don't need full ORM for this
		if(!$user) {
			Messages::add("error", "User not found");
			return Redirect::to_action("Admin.User");
		}
		return View::make('admin.users.form', array("userdata" => $user, "title" => "Edit user {$user->username} | Users | Admin", "javascript" => array("admin")));
	}

	// Editing
	public function post_edit($id) {
		$user = User::find($id);
		if(!$user) {
			Messages::add("error", "User not found");
			return Redirect::to_action("Admin.User");
		}
		// Angry checkbox man!
		if(!Input::get("admin")) {
			Input::merge(array("admin" => 0));
		}
		$countries = require path("app")."countries.php";
		$countries = array_keys($countries);
		$validation_rules = array( // Make sure it fits requirements and username and minecraft username are unique (except for current one)
			'username'  => "required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users,username,{$user->id}",
			'mc_username' => "required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users,mc_username,{$user->id}",
			"rank" => "numeric|between:0,4",
			"country" => 'in:'.implode(",", $countries),
			"reddit" => 'match:"/^[\w-]{3,20}$/i"', // validation parameters are parsed as csv
			"twitter" => 'match:"/^[\w]{1,15}$/i"',
			"youtube" => 'match:"/^[\w]{3,20}$/i"',
			"webzone" => "url"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// Should be safe for mass-assignment
			$user->username = Input::get("username");
			$user->mc_username = Input::get("mc_username");
			$user->admin = Input::get("admin");
			$user->rank = Input::get("rank");
			$profile = $user->profile;
			$profile->country = Input::get("country");
			$profile->reddit = Input::get("reddit");
			$profile->twitter = Input::get("twitter");
			$profile->youtube = Input::get("youtube");
			$profile->webzone = Input::get("webzone");
			$changed = array_merge(array_keys($user->get_dirty()), array_keys($profile->get_dirty()));
			if($user->save() && $profile->save()) {
				Event::fire("admin", array("user", "edit", $user->id, $changed));
				Messages::add("success", "User updated!");
				return Redirect::to_action("admin.user");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action('admin.user@edit', array($id))->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action('admin.user@edit', array($id))->with_input()->with_errors($validation);
		}
	}

	//Admin
	public function get_admin($id) {
		$user = User::find($id); // Don't need full ORM for this
		if(!$user) {
			Messages::add("error", "User not found");
			return Redirect::to_action("Admin.User");
		}
		return View::make('admin.users.admin', array("title" => "Admin user {$user->username} | Users | Admin", "javascript" => array("admin"), "user" => $user));
	}
	public function post_admin($id) {
		$user = User::find($id);
		if(!$user) {
			Messages::add("error", "User not found");
			return Redirect::to_action("admin.user");
		}
		$user->admin = 1;
		if($user->save()) {
			Event::fire("admin", array("user", "admin", $user->id));
			Messages::add("success", "User made administrator!");
			return Redirect::to_action("admin.user");
		} else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("admin.user");
		}
	}
	public function get_unadmin($id) {
		$user = User::find($id); // Don't need full ORM for this
		if(!$user) {
			Messages::add("error", "User not found");
			return Redirect::to_action("Admin.User");
		}
		return View::make('admin.users.unadmin', array("title" => "UnAdmin user {$user->username} | Users | Admin", "javascript" => array("admin"), "user" => $user));
	}
	public function post_unadmin($id) {
		$user = User::find($id);
		if(!$user) {
			Messages::add("error", "User not found");
			return Redirect::to_action("admin.user");
		}
		$user->admin = 0;
		if($user->save()) {
			Event::fire("admin", array("user", "unadmin", $user->id));
			Messages::add("success", "User un-administratored!");
			return Redirect::to_action("admin.user");
		} else {
			Messages::add("error", "Failed to save");
			return Redirect::to_action("admin.user");
		}
	}
}