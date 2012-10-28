<?php

class Maps_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("new", "edit", "rate", "comment", "edit_meta", "add_author", "author_invite", "edit_link", "delete_link", "upload_image", "default_image", "delete_image"));
		$this->filter("before", "csrf")->on("post")->only(array("new", "rate", "comment", "edit_meta", "add_author", "author_invite", "edit_link", "delete_link", "upload_image", "default_image", "delete_image"));
	}

	public function get_index() {
		$maps = Map::order_by("created_at", "desc")->where_published(1)->paginate(12);
		return View::make("maps.home", array("title" => "Maps", "javascript" => array("maps", "list"), "maps" => $maps, "menu" => "multiview"));
	}
	public function get_filter() {
		//retrieve GET info
		$order_column = strtolower(Input::get('order'));
		$category = strtolower(Input::get('type'));
		$featured = strtolower(Input::get('featured'));
		$official = strtolower(Input::get('official'));
		$own = strtolower(Input::get('ownmaps'));
		$limit = intval(Input::get('limit', null)) ?: 12;

		//start to make $query
		$query = Map::with("users");

		// own maps
		if($own && Auth::user()) {
			$query = Auth::user()->maps()->where("confirmed", "=", 1)->with("confirmed");
		} else {
			// Only allow seeing published maps
			$query = $query->where_published(1);
		}
		
		//orderby
		switch ($order_column)
		{
			case "newest":
				$query = $query->order_by("maps.created_at", "desc");
				break;
			
			case "oldest":
				$query = $query->order_by("maps.created_at", "asc");
				break;
			
			case "best":
				$query = $query->order_by("maps.avg_rating", "desc");
				break;
			
			case "worst":
				$query = $query->order_by("maps.avg_rating", "asc");
				break;
			
			default:
				$query = $query->order_by("maps.created_at", "desc");
				break;
		}
		
		//categories
		$category_list = Config::get("maps.types");
		if(isset($category_list[$category]) and $category != "") {
			$query = $query->where("maps.maptype", '=', $category);
		}

		//$featured
		if ($featured == "true")
		{
			$query = $query->where("maps.featured", '=', 1);
		}
		
		//$official
		if ($official == "true")
		{
			$query = $query->where("maps.official", '=', 1);
		}
		
		//run $query
		$maps = $query->paginate($limit);
		return View::make("maps.home", array("title" => "Filtered Maps", "javascript" => array("maps", "list"), "maps" => $maps, "menu" => "multiview"));
	}
	public function get_new() {
		return View::make("maps.new", array("javascript" => array("maps", "edit"), "menu" => "multiview", "sidebar" => "edit"));
	}
	public function post_new() {
		$validation_rules = array(
			"title"       => "required|between:3,128",
			"summary"     => "required|max:140",
			"description" => "required",

			"maptype" => 'in:'.implode(",", array_keys(Config::get("maps.types"))),
			"version" => "max:64",
			"mcversion" => "max:64",
			"teamcount" => "integer",
			"teamsize" => "integer"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			// New map
			$map = new Map();
			$map->title = Input::get("title");
			$map->summary = Input::get("summary");
			$map->description = IoC::resolve('HTMLPurifier')->purify(Input::get("description"));
			$map->maptype     = Input::get("maptype");
			$map->version     = Input::get("version");
			$map->mcversion   = Input::get("mcversion");
			$map->teamcount   = Input::get("teamcount");
			$map->teamsize    = Input::get("teamsize");
			$map->avg_rating  = 0;
			$map->save();
			// Attach user as creator
			$user = Auth::user();
			$map->users()->attach($user->id, array("confirmed" => true));
			//Create new publish Modqueue item
			$modqueue = new Modqueue();
			$modqueue->user_id = $user->id;
			$modqueue->type = "publish";
			$modqueue->itemtype = "map";
			$modqueue->itemid = $map->id;
			$modqueue->save();
			return Redirect::to_action("maps@view", array($map->id, $map->slug));
		} else {
			return Redirect::to_action("maps@new")->with_input()->with_errors($validation);
		}
	}
	public function get_view($id, $slug = null) {
		$map = Map::with(array("comments", "comments.user", "images"))->find($id); // Don't really have to care about the slug
		if(!$map) {
			return Response::error('404');
		}
		if($slug != $map->slug) { // Being nice
			return Redirect::to_action("maps@view", array($id, $map->slug));
		}
		$is_owner = false;
		$rating = 0;
		if(Auth::check()) {
			$is_owner = $map->is_owner(Auth::user());
			if($ratingObj = $map->ratings()->where_user_id(Auth::user()->id)->first()) {
				$rating = $ratingObj->rating;
			}
		}
		if(!$map->published && (Auth::guest() || $is_owner === false && !Auth::user()->admin)) {
			return Response::error("403"); // Not yet published
		}
		$modqueue = null;
		if(!$map->published && Auth::check() && Auth::user()->admin) {
			$modqueue = Modqueue::where_itemtype('map')->where_itemid($map->id)->first();
		}
		$authors = $map->users()->where("confirmed", "=", 1)->with("confirmed")->get();
		$social = array(
			"title" => $map->title, "type" => "article", "url" => action("maps@view", array($map->id, $map->slug)), "description" => $map->summary
		);
		if($map->image_id) {
			foreach ($map->images as $image) {
				if($image->id == $map->image_id) {
					$social["image"] = URL::to_asset($image->file_medium);
					break;
				}
			}
		}

		return View::make("maps.view", array(
			"title" => e($map->title)." | Maps", "map" => $map, "authors" => $authors, "is_owner" => $is_owner, "rating" => $rating,
			"modqueue" => $modqueue, "javascript" => array("maps", "view"), "sidebar" => "view", "menu" => "map",
			"social" => $social
		));
	}
	public function post_rate($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user()); // User is confirmed to be logged in
		if($is_owner) {
			return Redirect::to_action("maps@view", array($map->id, $map->slug)); // Can't rate own map
		}

		$validation_rules = array("rating" => 'required|numeric|between:1,5');
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) { 	// Skip to redirection if doesn't pass

			$ratingObj = $map->ratings()->where_user_id(Auth::user()->id)->first();
		
			if($ratingObj) { // Change vote
				$ratingObj->rating = Input::get("rating");
				$ratingObj->save();
				Messages::add("success", "Your rating has been updated");
			} else { // New vote
				$ratingObj = new Map_Rating();
				$ratingObj->user_id = Auth::user()->id;
				$ratingObj->rating = Input::get("rating");
				$map->ratings()->insert($ratingObj);
				Messages::add("success", "Your rating has been added");
			}
			$map->update_avg_rating();
		}
		return Redirect::to_action("maps@view", array($map->id, $map->slug));
	}

	// Commenting
	public function post_comment($id) {
		$mapitem = Map::find($id);
		if(!$mapitem) {
			return Response::error('404');
		}
		if(!$mapitem->published && (Auth::guest() || !Auth::user()->admin)) {
			return Response::error("404"); // Not yet published
		}

		$validation_rules = array("comment" => "required");
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$newcomment = new Comment();
			$newcomment->source = Input::get("comment");
			$newcomment->user_id = Auth::user()->id;
			$newcomment->map_id = $id;
			$mapitem->update_comment_count();
			Auth::user()->update_comment_count();

			$newcomment->save();
			$mapitem->save();
			Messages::add("success", "Comment posted!");
			return Redirect::to_action("maps@view", array($id, $mapitem->slug));
		} else {
			Messages::add("error", "Your comment has not been posted");
			return Redirect::to_action("maps@view", array($id, $mapitem->slug))->with_errors($validation)->with_input();
		}
	}


	/* Editing map */
	public function get_edit($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user()); // User is confirmed to be logged in
		if(!$is_owner) {
			return Response::error("404"); // Not owner
		}
		
		$authors = $map->users()->with("confirmed")->get();

		return View::make("maps.edit", array(
			"title" => "Editing: ".e($map->title)." | Maps", "map" => $map, "is_owner" => $is_owner, "authors" => $authors, "sidebar" => "edit", "javascript" => array("maps","edit"), "menu" => "mapedit"
		));
	}
	/* Edit metadata */
	public function post_edit_meta($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404"); // Not owner
		}

		$validation_rules = array(
			"title"       => "required|between:3,128",
			"summary"     => "required|max:255",
			"description" => "required",

			"maptype" => 'in:'.implode(",", array_keys(Config::get("maps.types"))),
			"version" => "max:64",
			"mcversion" => "max:64",
			"teamcount" => "integer",
			"teamsize" => "integer"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$map->title       = Input::get("title");
			$map->summary     = Input::get("summary");
			$map->description = IoC::resolve('HTMLPurifier')->purify(Input::get("description"));
			$map->maptype     = Input::get("maptype");
			$map->version     = Input::get("version");
			$map->mcversion   = Input::get("mcversion");
			$map->teamcount   = Input::get("teamcount");
			$map->teamsize    = Input::get("teamsize");
			$map->save();
			Messages::add("success", "Map updated!");
			return Redirect::to_action("maps@edit", array($map->id));
		} else {
			Messages::add("error", "Hold on cowboy, something just ain't right!");
			return Redirect::to_action("maps@edit", array($map->id))->with_input()->with_errors($validation);
		}		
	}
	/* Adding authors */
	public function post_add_author($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("404");
		}
		// Custom validation, since gonna need the user object anyway
		if(strlen(Input::get("username")) == 0) {
			Messages::add("error", "Can't add user! Please enter an username");
			return Redirect::to_action("maps@edit", array($map->id))->with_input();
		}
		// Find the user
		$user = User::where_username(Input::get("username"))->first();
		if(!$user) {
			Messages::add("error", "Can't add user! User not found");
			return Redirect::to_action("maps@edit", array($map->id))->with_input();
		}
		// Make sure user isn't already linked to the map (also filters out self)
		if($map->is_owner($user) !== false) {
			Messages::add("error", "Can't add user! User is already invited or an author");
			return Redirect::to_action("maps@edit", array($map->id))->with_input();
		}
		// All good now, create the invite
		$map->users()->attach($user->id, array("confirmed" => 0));
		$mapurl = URL::to_action("maps@view", array($map->id, $map->slug));
		$currentuser = Auth::user();
		$message = <<<EOT
You have been invited to be listed as an author of **{$map->title}** by {$currentuser->username}.

You can accept or deny this invite from [the map page]({$mapurl}).
EOT;
		$user->send_message("You have been invited to be an author on map {$map->title}", $message);
		Messages::add("success", "{$user->username} has been invited to be an author of this map. He/she must accept this invite to be listed as an author.");
		return Redirect::to_action("maps@edit", array($map->id));
	}
	/* Accepting / denying author invite */
	public function post_author_invite($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if($map->is_owner(Auth::user()) !== 0) { // User is invited to be author
			return Response::error("404");
		}

		if(Input::get("action") == "accept") {
			DB::table("map_user")->where_map_id($map->id)->where_user_id(Auth::user()->id)->update(array("confirmed" => true));
			// Remove this user's rating, since authors can't rate their own maps
			$ratingObj = $map->ratings()->where_user_id(Auth::user()->id)->first();
			if($ratingObj) {
				$ratingObj->delete();
				$map->update_avg_rating();
			}

			Messages::add("success", "You have accepted the invite");
			return Redirect::to_action("maps@view", array($map->id, $map->slug));
		} elseif(Input::get("action") == "deny") {
			DB::table("map_user")->where_map_id($map->id)->where_user_id(Auth::user()->id)->delete();
			Messages::add("success", "You have denied the invite");
			return Redirect::to("maps");
		}
	}
	/* Editing links */
	public function get_edit_link($id, $linkid = null) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user());
		if(!$is_owner) { // User is confirmed to be logged in
			return Response::error("404");
		}

		if($linkid) { // Editing link
			$link = $map->links()->where_id($linkid)->first();
			if(!$link) {
				return Response::error("404"); // Not map's link
			}
		} else { // New link
			$link = new Map_Link();
		}

		return View::make("maps.edit_link", array(
			"title" => "Add link | ".e($map->title)." | Maps", "map" => $map, "is_owner" => $is_owner, "link" => $link, "menu" => "mapedit"
		));
	}
	public function post_edit_link($id, $linkid = null) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("403"); // Not yet published
		}
		if($linkid) { // Editing link
			$link = $map->links()->where_id($linkid)->first();
			if(!$link) {
				return Response::error("404"); // Not map's link
			}
		} else { // New link
			$link = new Map_Link();
		}

		$validation_rules = array(
			"url" => "required|url",
			"type" => "required|in:rar,zip,7z",
			"direct" => "in:0,1"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$link->url = Input::get("url");
			$link->type = Input::get("type");
			$link->direct = Input::get("direct");
			if(!$link->exists) {
				$map->links()->insert($link);
			} else {
				$link->save();
			}
			Messages::add("success", "Link added!");
			return Redirect::to_action("maps@edit", array($id));
		} else {
			if($linkid) {
				$redirect = Redirect::to_action("maps@edit_link", array($id, $linkid));
			} else {
				$redirect = Redirect::to_action("maps@edit_link", array($id));
			}
			return $redirect->with_input()->with_errors($validation);
		}
	}
	// Deleting links
	public function get_delete_link($id, $linkid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user());
		if(!$is_owner) { // User is confirmed to be logged in
			return Response::error("403"); // Not yet published
		}
		$link = $map->links()->where_id($linkid)->first();
		if(!$link) {
			return Response::error("404"); // Not map's link
		}

		return View::make("maps.delete_link", array("title" => "Delete link | ".e($map->title)." | Maps", "map" => $map,  "is_owner" => $is_owner, "link" => $link, "menu" => "mapedit"));
	}
	public function post_delete_link($id, $linkid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("403"); // Not yet published
		}
		$link = $map->links()->where_id($linkid)->first();
		if(!$link) {
			return Response::error("404"); // Not map's link
		}

		if($link->delete()) {
			Messages::add("success", "Link deleted!");
		} else {
			Messages::add("error", "Failed to delete link!");
		}
		return Redirect::to_action("maps@edit", array($id));
	}
	/* Uploading images */
	public function post_upload_image($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("403"); // Not yet published
		}
		
		$input = Input::all();
		if(!isset($input["name"]) || strlen($input["name"]) == 0) { // Just use the filename
			$input["name"] = $input["uploaded"]["name"];
		}
		$validation_rules = array(
			"uploaded" => "required|image|max:1000",
			"name" => "required|max:200"
		);
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$image = Image::create(array("file" => $input["uploaded"], "filename" => $input["name"], "type" => "map"));
			$map->images()->attach($image->id);
			if(!$map->image_id) {
				$map->image_id = $image->id;
				$map->save();
			}
			Messages::add("success", "Image added!");
			return Redirect::to_action("maps@edit", array($id));
		} else {
			Messages::add("error", "Error while uploading the image.");
			return Redirect::to_action("maps@edit", array($id))->with_errors($validation);
		}
	}
	/* Default image */
	public function post_default_image($id, $imageid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("403"); // Not yet published
		}
		$image = $map->images()->where_image_id($imageid)->first();
		if(!$image) {
			return Response::error("404"); // Not map's image
		}

		$map->image_id = $image->id;
		$map->save();
		
		Messages::add("success", "Default image set");
		return Redirect::to_action("maps@edit", array($id));
	}
	/* Deleting images */
	public function get_delete_image($id, $imageid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user());
		if(!$is_owner) { // User is confirmed to be logged in
			return Response::error("403"); // Not yet published
		}
		$image = $map->images()->where_image_id($imageid)->first();
		if(!$image) {
			return Response::error("404"); // Not map's image
		}

		return View::make("maps.delete_image", array("title" => "Delete image | ".e($map->title)." | Maps", "map" => $map,  "is_owner" => $is_owner, "image" => $image, "menu" => "mapedit"));
	}
	public function post_delete_image($id, $imageid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!$map->is_owner(Auth::user())) { // User is confirmed to be logged in
			return Response::error("403"); // Not yet published
		}
		$image = $map->images()->where_image_id($imageid)->first();
		if(!$image) {
			return Response::error("404"); // Not map's image
		}

		if($map->images()->detach($image->id)) {
			if($map->image_id == $image->id) {
				$map->image_id = null;
				$map->save();
			}
			Messages::add("success", "Image removed!");
		} else {
			Messages::add("error", "Failed to remove image!");
		}
		return Redirect::to_action("maps@edit", array($id));
	}
}