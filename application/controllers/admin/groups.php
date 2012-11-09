<?php
class Admin_Groups_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("edit", "delete"));
	}

	public function get_index() {
		$groups = Group::get();
		return View::make("admin.groups.list", array("groups" => $groups, "title" => "Groups | Admin", "javascript" => array("admin")));
	}

	// Edit
	public function get_edit($id) {
		$group = Group::find($id);
		if(!$group) {
			Messages::add("error", "Group not found");
			return Redirect::to_action("admin.groups");
		}
		return View::make("admin.groups.edit", array("title" => "Edit ".e($group->name)." | Groups | Admin", "javascript" => array("admin"), "group" => $group));
	}
	public function post_edit($id) {
		$group = Group::find($id);
		if(!$group) {
			Messages::add("error", "Group not found");
			return Redirect::to_action("admin.groups");
		}
		$validation_rules = array(
			"name"       	=> "required|between:3,128",	
			"description"	=> "required|between:3,160",
		);
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$group->name       	= Input::get("name");
			$group->description = Input::get("description");
			$group->open      	= Input::get("private") == "on" ? 0 : 1;

			$group->save();
			$changed = array_keys($group->get_dirty());
			if($group->save()) {
				Event::fire("admin", array("group", "edit", $group->id, $changed));
				Messages::add("success", "Group updated!");
				return Redirect::to_action("admin.groups");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.groups@edit")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.groups@edit", array($id))->with_input()->with_errors($validation);
		}
	}

	// Delete form. DO NOT EVER DO ACTUAL DELETEION IN A GET METHOD
	public function get_delete($id) {
		$group = Group::find($id);
		if(!$group) {
			Messages::add("error", "Group not found");
			return Redirect::to_action("admin.groups");
		}
		return View::make("admin.groups.delete", array("title" => "Delete ".e($group->title)." | Groups | Admin", "javascript" => array("admin"), "group" => $group));
	}
	// Deletion
	public function post_delete($id) {
		$group = Group::find($id);
		if(!$group) {
			Messages::add("error", "Group not found");
			return Redirect::to_action("admin.groups");
		}
		$group->delete();
		Event::fire("admin", array("group", "delete", $group->id));
		Messages::add("success", "Group deleted!");
		return Redirect::to_action("admin.groups");
	}
}
?>