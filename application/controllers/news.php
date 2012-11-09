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

		// Align everyone with
		$comments = array(); // First level
		$comment_lookup = array();
		foreach ($newsitem->comments as $comment) {
			if($comment->reply_id && isset($comment_lookup[$comment->reply_id])) {
				$comment_lookup[$comment->reply_id]->children[] = $comment;
			} else {
				$comments[$comment->id] = $comment;
			}
			$comment_lookup[$comment->id] = $comment;
		}

		$social = array(
			"title" => $newsitem->title, "type" => "article", "url" => action("news@view", array($newsitem->id, $newsitem->slug)), "description" => $newsitem->summary
		);
		if($newsitem->image) {
			$social["image"] = URL::to_asset($newsitem->image->file_medium);
		}

		return View::make("news.view", array("title" => e($newsitem->title)." | News", "article" => $newsitem, "comments" => $comments, "social" => $social));
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
			$newcomment = new Comment();
			$newcomment->source = Input::get("comment");
			$newcomment->user_id = Auth::user()->id;
			$newcomment->news_id = $id;
			$newsitem->update_comment_count();
			Auth::user()->update_comment_count();

			$newcomment->save();
			$newsitem->save();
			Messages::add("success", "Comment posted!");
			return Redirect::to_action("news@view", array($id, $newsitem->slug));
		} else {
			Messages::add("error", "Your comment has not been posted");
			return Redirect::to_action("news@view", array($id, $newsitem->slug))->with_errors($validation)->with_input();
		}
	}

	// RSS Feed of awesome
	public function get_feed($method = "atom") {
		if(!in_array($method, array("atom", "rss"))) { // Only types supported
			return Response::error('404');
		}
		$posts = News::with(array("image", "user"))->where_published(1)->order_by("created_at", "desc")->take(25)->get();

		$feed = new Feed();

		$feed->title = 'Major League Mining News Fuse';
		$feed->description = 'The latest news articles as written by the team of Major League Mining.';
		$feed->link = URL::to_action('news@feed', array($method));
		$feed->pubdate = $posts[0]->created_at;
		$feed->lang = 'en';

		foreach ($posts as $post) {
			$feed->add($post->title, $post->user->username, URL::to_action("news@view", array($post->id, $post->slug)), $post->created_at, $post->content);
		}

		return $feed->render($method);
	}
}