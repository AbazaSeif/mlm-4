<?php

class News_Controller extends Base_Controller {
	public $restful = true;

	// News listing
	public function get_index() {
		$newslist = News::with("image")->where_published(1)->order_by("created_at", "desc")->paginate(10);
		return View::make("news.list", array("title" => "News", "newslist" => $newslist));
	}
	// Viewing an article
	public function get_view($id, $slug = null) {
		$newsitem = News::find($id); // Don't really have to care about the slug
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
}