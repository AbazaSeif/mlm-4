<?php
class Admin_Pages_Controller extends Admin_Controller {
	
	public $restful = true;
	
	public function get_index() {
		$pages = DB::table("pages")->get(array("id", "title", "url_slug"));
		return View::make('admin.pages.list', array("pages" => $pages, "javascript" => array("admin")));
	}

	// Create
	public function get_new() {
		return View::make("admin.pages.new", array("title" => "New Page | Pages | Admin", "javascript" => array("admin")));
	}
	public function post_new() {
		$validation_rules = array(
			"title" => "required|min:5|max:50",
			"slug" => "required|max:20",
			"data" => "required"
		);
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$page = new Page();
			$page->title = $input["title"];
			$page->url_slug = $input["slug"];
			$page->data = IoC::resolve('HTMLPurifier')->purify($input["data"]);
			if($page->save()) {
				Event::fire("admin", array("pages", "add", $page->id));
				Messages::add("success", "Page created!");
				return Redirect::to_action("admin.pages");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.pages@new")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.pages@new")->with_input()->with_errors($validation);
		}
	}

	// Edit
	public function get_edit($id) {
		$page = Page::find($id);
		if(!$page) {
			Messages::add("error", "Page not found");
			return Redirect::to_action("admin.pages");
		}
		return View::make("admin.pages.edit", array("title" => "Edit ".e($page->title)." | Pages | Admin", "javascript" => array("admin"), "page" => $page));
	}
	public function post_edit($id) {
		$page = Page::find($id);
		if(!$page) {
			Messages::add("error", "Page not found");
			return Redirect::to_action("admin.pages");
		}
		$validation_rules = array(
			"title" => "required|min:5|max:50",
			"slug" => "required|max:20",
			"data" => "required"
		);
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$page->title = $input["title"];
			$page->url_slug = $input["slug"];
			$page->data = IoC::resolve('HTMLPurifier')->purify($input["data"]);
			$changed = array_keys($page->get_dirty());
			if($page->save()) {
				Event::fire("admin", array("pages", "edit", $page->id, $changed));
				Messages::add("success", "Page edited!");
				return Redirect::to_action("admin.pages");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.pages@edit")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.pages@edit")->with_input()->with_errors($validation);
		}
	}

	// Delete
	// Delete form. DO NOT EVER DO ACTUAL DELETEION IN A GET METHOD
	public function get_delete($id) {
		$page = Page::find($id);
		if(!$page) {
			Messages::add("error", "Page not found");
			return Redirect::to_action("admin.pages");
		}
		return View::make("admin.pages.delete", array("title" => "Delete ".e($page->title)." | Pages | Admin", "javascript" => array("admin"), "page" => $page));
	}
	// Deletion
	public function post_delete($id) {
		$page = Page::find($id);
		if(!$page) {
			Messages::add("error", "Page not found");
			return Redirect::to_action("admin.pages");
		}
		$page->delete();
		Event::fire("admin", array("news", "delete", $page->id));
		Messages::add("success", "Page deleted!");
		return Redirect::to_action("admin.pages");
	}
}