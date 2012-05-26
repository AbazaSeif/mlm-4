<?php
class Admin_User_Controller extends Admin_Controller {
	public $restful = true;
	
	public function get_index() {
		$users = DB::table("users")->get(array("id", "username", "mc_username"));
		return View::make('admin.users.list', array("users" => $users));
	}
	public function get_edit($id) {
		$user = DB::table("users")->find($id);
		if(!$user) {
			return Redirect::to_action("Admin.User");
		}
		return View::make('admin.users.form', array("userdata" => $user));
	}
}