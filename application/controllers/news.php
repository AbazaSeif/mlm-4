<?php

class News_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("comment"));
		$this->filter("before", "csrf")->on("post")->only(array("comment"));
	}

	// News listing
	public function get_index() {
		$newslist = News::with(array("image", "user"))->where_published(1)->order_by("created_at", "desc")->paginate(10);
		return View::make("news.list", array("title" => "News", "newslist" => $newslist));
	}
	// Viewing an article
	public function get_view($id, $slug = null) {
		$newsitem = News::with(array("user", "comments", "comments.user"))->find($id); // Don't really have to care about the slug
		if(!$newsitem) {
			return Response::error('404');
		}
		if($slug != $newsitem->slug) { // Being nice
			return Redirect::to_action("news@view", array($id, $newsitem->slug));
		}
		if(!$newsitem->published && (Auth::guest() || !Auth::user()->admin)) {
			return Response::error("404"); // Not yet published
		}
		return View::make("news.view", array("title" => e($newsitem->title)." | News", "article" => $newsitem));
	}
	// Commenting
	public function post_comment($id) {
		$newsitem = News::find($id);
		if(!$newsitem) {
			return Response::error('404');
		}
		if(!$newsitem->published && (Auth::guest() || !Auth::user()->admin)) {
			return Response::error("404"); // Not yet published
		}

		$validation_rules = array("comment" => "required");
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$newcomment = new News_Comment();
			$newcomment->source = Input::get("comment");
			$newcomment->user_id = Auth::user()->id;
			$newsitem->comments()->insert($newcomment);
			$newsitem->update_comment_count();

			Messages::add("success", "Comment posted!");
			return Redirect::to_action("news@view", array($id, $newsitem->slug));
		} else {
			Messages::add("error", "Your comment has not been posted");
			return Redirect::to_action("news@view", array($id, $newsitem->slug))->with_errors($validation)->with_input();
		}
	}
}