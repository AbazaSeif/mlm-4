<?php

class News_Controller extends Base_Controller {
	public $restful = true;

	public function get_index() {
		$newslist = News::with("image")->where_published(1)->order_by("created_at", "desc")->paginate(10);
		return View::make("news.list", array("title" => "News", "newslist" => $newslist));
	}
}