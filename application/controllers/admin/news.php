<?php
class Admin_News_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("new", "edit"));
	}
	
	public function get_index() {
		$news = DB::table("news")->order_by("id", "desc")->get(array("id", "title", "slug"));
		return View::make("admin.news.list", array("news" => $news, "title" => "News | Admin"));
	}
	public function get_new() {
		return View::make("admin.news.newform", array("title" => "New | News | Admin"));
	}
	public function post_new() {
		$validation_rules = array(
			"title" => "required|min:10|max:200",
			"summary" => "required|max:1024",
			"image" => "required|exists:images,id",
			"news_content" => "required"
		);
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$newsitem = new News();
			$newsitem->title = $input["title"];
			$newsitem->summary = $input["summary"];
			$newsitem->image_id = $input["image"];
			$newsitem->content = IoC::resolve('HTMLPurifier')->purify($input["news_content"]);
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
}