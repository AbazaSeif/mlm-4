<?php
class Admin_User_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only("edit");
	}

	public function get_index() {
		$users = DB::table("users")->get(array("id", "username", "mc_username"));
		return View::make('admin.users.list', array("users" => $users, "title" => "Users | Admin"));
	}
	public function get_edit($id) {
		$user = DB::table("users")->find($id); // Don't need full ORM for this
		if(!$user) {
			Messages::add("error", "User not found");
			return Redirect::to_action("Admin.User");
		}
		return View::make('admin.users.form', array("userdata" => $user, "title" => "Edit user {$user->username} | Users | Admin"));
	}
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
		$validation_rules = array(
			'username'  => "required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users,username,{$user->id}",
			'mc_username' => "required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users,mc_username,{$user->id}"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// Should be safe for mass-assignment
			$user->username = Input::get("username");
			$user->mc_username = Input::get("mc_username");
			$user->admin = Input::get("admin");
			$changed = array_keys($user->get_dirty());
			if($user->save()) {
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
}