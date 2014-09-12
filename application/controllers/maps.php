<?php

class Maps_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();

		$this->filter("before", "auth")->only(array("new", "edit", "rate", "comment", "edit_meta", "add_author", "author_invite", "edit_version", "edit_link", "delete_link", "upload_image", "default_image", "delete_image"));
		$this->filter("before", "csrf")->on("post")->only(array("new", "rate", "comment", "edit_meta", "add_author", "author_invite", "edit_version", "edit_link", "delete_link", "upload_image", "default_image", "delete_image"));
	}

	public function get_index() {
		$maps = Map::with(array("users", "image", "version"))->order_by("created_at", "desc")->where_published(1)->paginate(12);
		return View::make("maps.home", array("title" => "Maps", "javascript" => array("maps", "list"), "maps" => $maps, "menu" => "multiview"));
	}
	public function get_filter() {
		//retrieve GET info
		$order_column = strtolower(Input::get('order'));
		$category = strtolower(Input::get('type'));
		$featured = strtolower(Input::get('featured'));
		$own = strtolower(Input::get('ownmaps'));
		$limit = intval(Input::get('limit', null)) ?: 12;

		//start to make $query
		$eager_relations = array("users", "image", "version");
		$query = Map::with($eager_relations);

		// own maps
		if($own && Auth::user()) {
			$query = Auth::user()->maps()->where("confirmed", "=", 1)->with("confirmed");
			// Prefetch for relational queries
			$query->model->_with($eager_relations);
		} else {
			// Only allow seeing published maps
			$query = $query->where_published(1);
		}
		// title
		if(Input::get("title")) {
			$query = $query->where("title", "LIKE", Input::get("title").'%');
		}
		// Replace with fulltext search when future happen

		// team count
		if($teamcount = intval(Input::get("teamcount"))) {
			$query = $query->where_teamcount($teamcount);
		}

		// team size
		if($teamsize = intval(Input::get("teamsize"))) {
			$query = $query->where_teamsize($teamsize);
		}

		// Minecraft version
		if(Input::get("mcversion")) {
			$query = $query->where("mcversion", "LIKE", Input::get("mcversion").'%');
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

		//run $query
		$maps = $query->paginate($limit);
		$appendage = Input::get();
		unset($appendage["page"]);
		$maps->appends($appendage);
		return View::make("maps.home", array("title" => "Search Maps", "javascript" => array("maps", "list"), "maps" => $maps, "menu" => "multiview"));
	}
	public function get_new() {
		return View::make("maps.new", array("title" => "New Map ", "javascript" => array("maps", "edit"), "menu" => "new", "sidebar" => "edit"));
	}
	public function post_new() {
		$validation_rules = array(
			"title"       => "required|between:3,128",
			"summary"     => "required|max:140",
			"description" => "required",

			"maptype" => 'in:'.implode(",", array_keys(Config::get("maps.types"))),
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
			$map->mcversion   = Input::get("mcversion");
			$map->teamcount   = Input::get("teamcount");
			$map->teamsize    = Input::get("teamsize");
			$map->avg_rating  = 0;
			$map->save();
			// Attach user as creator
			$user = Auth::user();
			$map->users()->attach($user->id, array("confirmed" => true));
			return Redirect::to_action("maps@view", array($map->id, $map->slug));
		} else {
			return Redirect::to_action("maps@new")->with_input()->with_errors($validation);
		}
	}
	public function get_view($id, $slug = null, $versionslug = null) {
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
		/* if(!$map->published && (Auth::guest() || $is_owner === false && !Auth::user()->admin)) {
			return Response::error("403"); // Not yet published
		} */
		$modqueue = null;
		if(!$map->published && Auth::check() && Auth::user()->admin) {
			$modqueue = Modqueue::where_itemtype('map')->where_itemid($map->id)->first();
		}

		if($versionslug) {
			$version = $map->versions()->where_version_slug($versionslug)->first();
			if(!$version) {
				return Redirect::to_action("maps@view", array($id, $map->slug));
			}
		} else {
			$version = $map->version;
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
			"modqueue" => $modqueue, "javascript" => array("maps", "view"), "sidebar" => "view", "menu" => "map", "version" => $version,
			"social" => $social
		));
	}
	/* Map downloading */
	public function get_get($mapid, $versionid = null) {
		$map = Map::find($mapid);
		if(!$map) {
			return Response::error('404');
		}
		// Don't bother checking for published
		if($versionid) {
			$version = $map->versions()->where_id($versionid)->first();
			if(!$version) {
				return Response::error("404");
			}
		} else {
			$version = $map->version;
		}

		// MAYBE-TODO: Maybe stats of downloads?

		return Response::download(path("storage")."maps/".$map->id."_".$version->id.".zip", $map->slug."-".$version->version_slug.".zip");
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
				Messages::add("success", "Your rating has been updated!");
			} else { // New vote
				$ratingObj = new Map_Rating();
				$ratingObj->user_id = Auth::user()->id;
				$ratingObj->rating = Input::get("rating");
				$map->ratings()->insert($ratingObj);
				Messages::add("success", "Thanks for rating! Mind leaving a comment?");
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
		/* if(!$mapitem->published && (Auth::guest() || !Auth::user()->admin)) {
			return Response::error("403"); // Not yet published
		} */

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

	public function post_reportcomment() {
		$id = Input::get("id");
		$type = Input::get("type");
		$details = Input::get("details");

		$comment = Comment::find($id);
		if (!$comment) {
			return Response::error('404');
		}

		$map = Map::find($comment->map_id);
		if(!$map) {
			return Response::error('404');
		}

		if (Modqueue::where('itemtype', '=', 'comment')->where('user_id', '=', Auth::user()->id)->where('itemid', '=', $id)->get() != null) {
			Messages::add("error", "Comment already reported!");
			return Redirect::to_action("maps@view", array($map->id, $map->slug));
		}

		else {
			$modqueue = new Modqueue();
			$modqueue->user_id = Auth::user()->id;
			$modqueue->type = $type;
			$modqueue->itemtype = "comment";
			$modqueue->itemid = $id;
			$modqueue->data = $details;

			$modqueue->save();
			Messages::add("success", "Comment reported!");
			return Redirect::to_action("maps@view", array($map->id, $map->slug));
		}
	}

	public function post_reportmap() {
		$id = Input::get("id");
		$type = Input::get("type");
		$details = Input::get("details");

		$map = Map::find($id);
		if (!$map) {
			return Response::error('404');
		}

		if (Modqueue::where('itemtype', '=', 'map')->where('user_id', '=', Auth::user()->id)->where('itemid', '=', $id)->get() != null) {
			Messages::add("error", "Map already reported!");
			return Redirect::to_action("maps@view", array($map->id, $map->slug));
		}

		else {
			$modqueue = new Modqueue();
			$modqueue->user_id = Auth::user()->id;
			$modqueue->type = $type;
			$modqueue->itemtype = "map";
			$modqueue->itemid = $id;
			$modqueue->data = $details;

			$modqueue->save();
			Messages::add("success", "Map reported!");
			return Redirect::to_action("maps@view", array($map->id, $map->slug));
		}
	}


	/* Editing map */
	public function get_edit($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		$is_owner = $map->is_owner(Auth::user()); // User is confirmed to be logged in
		if(!$is_owner && !Auth::user()->admin) {
			return Response::error("403"); // Not owner
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
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403"); // Not owner
		}

		$validation_rules = array(
			"title"       => "required|between:3,128",
			"summary"     => "required|max:255",
			"description" => "required",

			"maptype" => 'in:'.implode(",", array_keys(Config::get("maps.types"))),
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
			$map->mcversion   = Input::get("mcversion");
			$map->teamcount   = Input::get("teamcount");
			$map->teamsize    = Input::get("teamsize");
			if($is_owner) {
				$saved = $map->save();
			} else {
				$changed = array_keys($map->get_dirty());
				if($saved = $map->save()) {
					Event::fire("admin", array("maps", "edit", $map->id, $changed));
				}
			}
			if($saved) {
				Messages::add("success", "Map updated!");
				return Redirect::to_action("maps@edit", array($map->id));
			} else {
				Messages::added("error", "Error while saving, try again later?");
				return Redirect::to_action("maps@edit", array($map->id));
			}
		} else {
			Messages::add("error", "Hold on! you forgot something!");
			return Redirect::to_action("maps@edit", array($map->id))->with_input()->with_errors($validation);
		}
	}
	/* Adding authors */
	public function post_add_author($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
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
		if(!$is_owner) { // Admin mode - Autoaccept
			$map->users()->attach($user->id, array("confirmed" => true));
			// Remove this user's rating, since authors can't rate their own maps
			$ratingObj = $map->ratings()->where_user_id(Auth::user()->id)->first();
			if($ratingObj) {
				$ratingObj->delete();
				$map->update_avg_rating();
			}
			Event::fire("admin", array("map_users", "add", $map->id, $user->username));
			Messages::add("success", "{$user->username} has been added as an author.");
			return Redirect::to_action("maps@edit", array($map->id));
		} else {
			$map->users()->attach($user->id, array("confirmed" => false));
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
	}
	/* Accepting / denying author invite */
	public function post_author_invite($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if($map->is_owner(Auth::user()) !== 0) { // User is invited to be author
			return Response::error("403");
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
	/* Editing versions */
	public function get_edit_version($id, $versionid = null) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error("404");
		}

		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
		}

		if($versionid) {
			$version = $map->versions()->where_id($versionid)->first();
			if(!$version) {
				return Response::error("404");
			}
		} else {
			$version = new Map_Version();
		}

		return View::make("maps.edit_version", array(
			"title" => ($version->exists ? "Edit" : "New")." version | ". e($map->title)." | Maps", "map" => $map, "is_owner" => $is_owner,
			"version" => $version, "menu" => "mapedit"
		));
	}
	public function post_edit_version($id, $versionid = null) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error("404");
		}
		;
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
		}

		if($versionid) {
			$version = $map->versions()->where_id($versionid)->first();
			if(!$version) {
				return Response::error("404");
			}
		} else {
			$version = new Map_Version();
		}

		$validation_rules = array(
			"version" => "required|max:64",
			"changelog" => "required",
			"mapfile" => "mimes:zip|max:15360"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		$validation->passes(); // Dump messages

		// Checking the zip for proper map
		$mapinfo = false;
		$mapfile = Input::file("mapfile");
		if($mapfile["tmp_name"]) {
			$zip_check = new ZipArchive();
			// 1. Make sure it's a zip alright
			$map_input = Input::file("mapfile");
			if(($zip_err = $zip_check->open($map_input["tmp_name"])) !== TRUE) {
				if($zip_err == ZIPARCHIVE::ER_NOZIP) {
					$validation->errors->add("mapfile", "Uploaded file is not a zip");
				} else {
					$validation->errors->add("mapfile", "System error when checking zip for errors");
					Log::error("Error when parsing uploaded zip - Map id ".$map->id." - error code ".$zip_err);
				}
			} else {
				$parse_messages = new Laravel\Messages(); // error for things that just can't deal with, info for stuff that would be nice to be fixed

				$guessed_root = false;
				$missing = array("region", "level.dat");
				$autoref = false;
				for ($i=0; $i < $zip_check->numFiles; $i++) {
					$zipped_file = $zip_check->statIndex($i);
					$filename_parts = explode("/", $zipped_file["name"]);

					if($guessed_root == false) { // Ideally should be right from first entry
						$guessed_root = $filename_parts[0];
						if(strtolower($guessed_root) == "world") {
							$parse_messages->add("info", "Map folder is called \"world\", you should give it a more aproptiate title");
						}
					} else {
						if($filename_parts[0] != $guessed_root) {
							$parse_messages->add("error", "Files found outside map folder!");
						}
					}

					if(isset($filename_parts[1]) and $filename_parts[1] == "region") {
						$missing = array_diff($missing, array("region"));
					}
					if(isset($filename_parts[1]) and $filename_parts[1] == "level.dat") {
						$missing = array_diff($missing, array("level.dat"));
					}
					if(isset($filename_parts[1]) and $filename_parts[1] == "autoreferee.xml") {
						$autoref = true;
					}
					if(isset($filename_parts[2]) and $filename_parts[1] == "players" and strlen($filename_parts[2])) {
						$parse_messages->add("info", "Found non-empty players folder, you should either delete the folder or delete it's contents.");
					}
					if(isset($filename_parts[2]) and $filename_parts[1] == "region" and ends_with($filename_parts[2], ".mcr")) {
						$parse_messages->add("info", "Found region files in old format (pre-anvil). If the map is targeted for Minecraft 1.2 and later, you should delete it.");
					}
				}
				if(count($missing) > 0) {
					$parse_messages->add("error", "Missing following files/folders: ".implode(", ", $missing));
				}
				if(!$autoref) {
					$parse_messages->add("info", "No autoreferee configuration file detected. You should think about making one if it's possible.");
				}
				if($parse_messages->has("error")) {
					$validation->errors->add("mapfile", "Broken map file uploaded: <ul>".implode($parse_messages->get("error", "<li>:message</li>"))."</ul>");
					Messages::add("error", "While checking your map, the following errors occurred:<ul>".implode($parse_messages->get("error", "<li>:message</li>"))."</ul>");
				}
				if($parse_messages->has("info")) {
					Messages::add("info", "While checking your map, we noticed:<ul>".implode($parse_messages->get("info", "<li>:message</li>"))."</ul>While these won't break your map, it would be awesome if you'd fix them. Check <a href=\"http://majorleaguemining.net/mapmakerchecklist\" target=\"_blank\">The Mapmaker's checklist</a> for more info.");
				}
				$mapinfo = array("uploaded" => true, "autoref" => $autoref);
			}
		}

		if(count($validation->errors->messages) == 0) {
			$version->version = Input::get("version");
			$version->changelog = Input::get("changelog");
			if(!$is_owner) {
				$dirty = array_keys($version->get_dirty());
			}
			if(!$version->exists) {
				$map->versions()->insert($version);
				// Mark it as latest version by default
				$map->version_id = $version->id;
				$map->save();
			} else {
				$version->save();
			}
			// Upload?
			if($mapinfo) {
				Input::upload("mapfile", path("storage")."maps", $map->id."_".$version->id.".zip");
				$version->uploaded = $mapinfo["uploaded"];
				$version->autoref = $mapinfo["autoref"];
				if(!$is_owner) {
					$dirty = array_merge($dirty, array("mapfile"), array_keys($version->get_dirty()));
				}
				$version->save();
			}
			if(!$is_owner) {
				Event::fire("admin", array("map_versions", "edit", $version->id, array("map_id" => $map->id, $dirty)));
			}
			Messages::add("success", "Version saved!");
			return Redirect::to_action("maps@edit", array($id));
		} else {
			if($versionid) {
				$redirect = Redirect::to_action("maps@edit_version", array($id, $versionid));
			} else {
				$redirect = Redirect::to_action("maps@edit_version", array($id));
			}
			return $redirect->with_input()->with_errors($validation);
		}
	}

	// Deleting versions
	public function get_delete_version($id, $versionid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
		}
		$version = $map->versions()->where_id($versionid)->first();
		if(!$version) {
			return Response::error("404");
		}

		return View::make("maps.delete_version", array("title" => "Delete version | ".e($map->title)." | Maps", "map" => $map,  "is_owner" => $is_owner, "version" => $version, "menu" => "mapedit"));
	}
	public function post_delete_version($id, $versionid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
		}
		$version = $map->versions()->where_id($versionid)->first();
		if(!$version) {
			return Response::error("404");
		}

		if($version->delete()) {
			$filepath = path("storage")."maps/".$map->id."_".$version->id.".zip";
			if(File::exists($filepath)) {
				File::delete($filepath);
			}
			if($map->version_id == $version->id) {
				$freshest = $map->versions()->first();
				if($freshest) {
					$map->version_id = $freshest->id;
				} else {
					$map->version_id = null;
				}
				$map->save();
			}
			if(!$is_owner) {
				Event::fire("admin", array("map_versions", "delete", $version->id, array("map_id" => $map->id)));
			}
			Messages::add("success", "Version deleted!");
		} else {
			Messages::add("error", "Failed to delete the version!");
		}
		return Redirect::to_action("maps@edit", array($id));
	}

	/* Editing links */
	public function get_edit_link($id, $linkid = null) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
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
			"title" => ($link->exists ? "Edit" : "Add")." link | ".e($map->title)." | Maps", "map" => $map, "is_owner" => $is_owner,
			"link" => $link, "menu" => "mapedit"
		));
	}
	public function post_edit_link($id, $linkid = null) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
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
			"title" => "required|between:3,128",
			"url" => "required|url"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$link->title = Input::get("title");
			$link->url = Input::get("url");
			if(!$link->exists) {
				$map->links()->insert($link);
				if(!$is_owner) {
					Event::fire("admin", array("map_links", "new", $link->id, array("map_id" => $map->id, $link->get_dirty())));
				}
			} else {
				if(!$is_owner) {
					Event::fire("admin", array("map_links", "edit", $link->id, array("map_id" => $map->id, $link->get_dirty())));
				}
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
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
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
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
		}
		$link = $map->links()->where_id($linkid)->first();
		if(!$link) {
			return Response::error("404"); // Not map's link
		}

		if($link->delete()) {
			if(!$is_owner) {
				Event::fire("admin", array("map_links", "delete", $link->id, array("map_id" => $map->id)));
			}
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
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
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
			if(!$is_owner) {
				Event::fire("admin", array("map_images", "add", $image->id, array("map_id" => $map->id)));
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
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
		}
		$image = $map->images()->where_image_id($imageid)->first();
		if(!$image) {
			return Response::error("404"); // Not map's image
		}

		$map->image_id = $image->id;
		$map->save();
		if(!$is_owner) {
			Event::fire("admin", array("maps", "default_image", $map->id, array("image_id" => $image->id)));
		}

		Messages::add("success", "Default image set");
		return Redirect::to_action("maps@edit", array($id));
	}
	/* Deleting images */
	public function get_delete_image($id, $imageid) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
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
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
		}
		$image = $map->images()->where_image_id($imageid)->first();
		if(!$image) {
			return Response::error("404"); // Not map's image
		}

		if($map->images()->detach($image->id)) {
			if(!$is_owner) {
				Event::fire("admin", array("map_links", "delete", $image->id, array("map_id" => $map->id)));
			}
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
	public function post_publish($id) {
		$map = Map::find($id);
		if(!$map) {
			return Response::error('404');
		}
		if(!($is_owner = $map->is_owner(Auth::user())) && !Auth::user()->admin) { // User is confirmed to be logged in
			return Response::error("403");
		}

		//Publishing
		if ($map->published == '0' || $map->published == null)
		{
			/*
			//Check downloads, images etc.
			if ()count($map->images) <= 0) {
				Messages::add("error", "Couldn't publish map: No images attached to map!");
				return Redirect::to_action("maps@edit", array($id));
			}
			else if (count($map->links) <= 0) {
				Messages::add("error", "Couldn't publish map: No download links on map!");
				return Redirect::to_action("maps@edit", array($id));
			}
			else {
				*/{
				$map->published = '1';
				$map->save();

				if($map->admin_checked == '0' && (Modqueue::where_itemtype('map')->where_itemid($map->id)->where_type("admin_check")->first()) == null) {
					$modqueue = new Modqueue();
					$modqueue->user_id = Auth::user()->id;
					$modqueue->type = 'admin_check';
					$modqueue->itemtype = "map";
					$modqueue->itemid = $id;
					$modqueue->data = "Auto generated report for new maps. Please ensure the map is up to standard. Map Description:".$map->description." ";

					$modqueue->save();
				}
				return Redirect::to_action("maps@view", array($id));
			}
		}

		//UnPublishing
		else if ($map->published == '1')
		{
			$map->published = '0';
			$map->save();
			return Redirect::to_action("maps@view", array($id));
		}
	}
}