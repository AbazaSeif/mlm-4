<?php
class Admin_News_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("new", "edit", "delete"));
	}
	// Listing news
	public function get_index() {
		$news = DB::table("news")->order_by("id", "desc")->get(array("id", "title", "slug","user_id", "created_at", "published"));
		return View::make("admin.news.list", array("news" => $news, "title" => "News | Admin"));
	}
	// New form
	public function get_new() {
		if(Input::old("image")) { // If a image was selected, find the preview for it
			$oldimage = Image::find(Input::old("image"));
			if($oldimage) {
				$oldimage = URL::to_asset($oldimage->file_small);
			}
		} else {
			$oldimage = null;
		}

		return View::make("admin.news.new", array("title" => "New Article | News | Admin", "oldimage" => $oldimage));
	}
	public function post_new() {
		$validation_rules = array(
			"title" => "required|min:10|max:200",
			"summary" => "required|max:1024",
			"image" => "required|exists:images,id",
			"news_content" => "required"
		);
		// Angry checkbox man!
		if(!Input::get("published")) {
			Input::merge(array("published" => 0));
		}
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			// Yay, add the news item
			$newsitem = new News();
			$newsitem->title = $input["title"];
			$newsitem->summary = $input["summary"];
			$newsitem->image_id = $input["image"];
			$newsitem->content = IoC::resolve('HTMLPurifier')->purify($input["news_content"]);
			$newsitem->published = $input["published"];
			$newsitem->user_id = Auth::user()->id;
			if($newsitem->save()) {
				Event::fire("admin", array("news", "add", $newsitem->id));
				Messages::add("success", "News item posted!");
				return Redirect::to_action("admin.news");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.news@new")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.news@new")->with_input()->with_errors($validation);
		}
	}
	// Edit form
	public function get_edit($id) {
		$newsitem = News::find($id);
		if(!$newsitem) {
			Messages::add("error", "News item not found");
			return Redirect::to_action("admin.news");
		}
		if(Input::old("image")) { // Find a preview image, either one for last input or the current one
			$previewimage = Image::find(Input::old("image"));
			if($previewimage) {
				$previewimage = URL::to_asset($previewimage->file_small);
			}
		} else {
			$previewimage = URL::to_asset($newsitem->image->file_small);
		}
		return View::make("admin.news.form", array("title" => "Editing: ".e($newsitem->title)." | News | Admin", "newsitem" => $newsitem, "previewimage" => $previewimage));
	}
	// Saving edits
	public function post_edit($id) {
		$newsitem = News::find($id);
		if(!$newsitem) {
			Messages::add("error", "News item not found");
			return Redirect::to_action("admin.news");
		}
		$validation_rules = array(
			"title" => "required|min:10|max:200",
			"summary" => "required|max:1024",
			"image" => "required|exists:images,id",
			"news_content" => "required"
		);
		// Angry checkbox man!
		if(!Input::get("published")) {
			Input::merge(array("published" => 0));
		}
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$newsitem->title = $input["title"];
			$newsitem->summary = $input["summary"];
			$newsitem->image_id = $input["image"];
			$newsitem->content = IoC::resolve('HTMLPurifier')->purify($input["news_content"]);
			$newsitem->published = $input["published"];
			$changed = array_keys($newsitem->get_dirty());
			if(in_array("published", $changed) && $newsitem->published) { // unpublished -> published
				$newsitem->created_at = new DateTime;
			}
			if($newsitem->save()) {
				Event::fire("admin", array("news", "edit", $newsitem->id, $changed));
				Messages::add("success", "News item updated!");
				return Redirect::to_action("admin.news");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.news@edit")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.news@edit", array($id))->with_input()->with_errors($validation);
		}
	}
	// Delete form. DO NOT EVER DO ACTUAL DELETEION IN A GET METHOD
	public function get_delete($id) {
		$newsitem = News::find($id);
		if(!$newsitem) {
			Messages::add("error", "News item not found");
			return Redirect::to_action("admin.news");
		}
		return View::make("admin.news.delete", array("title" => "Delete ".e($newsitem->title)." | News | Admin", "newsitem" => $newsitem));
	}
	// Deletion
	public function post_delete($id) {
		$newsitem = News::find($id);
		if(!$newsitem) {
			Messages::add("error", "News item not found");
			return Redirect::to_action("admin.news");
		}
		$newsitem->delete();
		Event::fire("admin", array("news", "delete", $newsitem->id));
		Messages::add("success", "News item deleted!");
		return Redirect::to_action("admin.news");
	}
}