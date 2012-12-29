<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your applications using Laravel's RESTful routing, and it
| is perfectly suited for building both large applications and simple APIs.
| Enjoy the fresh air and simplicity of the framework.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post('hello, world', function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

// Home
Route::get('/', "maps@index");

// Awesome URL's - http://jasonlewis.me/blog/2012/09/laravel-routes-or-controllers
Route::get("login", "account@login");
Route::get("news/(:num)-(:any)", "news@view");
Route::get("map/(:num)-(:any)", "maps@view");
Route::get("map/(:num)-(:any)/(:any)", "maps@view"); // Map version

// Public routes
Route::controller(array("account", "imgmgr", "maps", "messages", "news", "faq", "test"));

// User pages
Route::get("user/(:any?)", function($username = null) {
	$userobj = false;
	if(!$username) { // If username isn't set
		if(Auth::check()) {
			return Redirect::to("user/".Auth::user()->username);
		}  else {
			return Response::error("404");
		}
	}

	$userobj = User::where_username($username)->first();
	if(!$userobj) {
		return Response::error("404");
	}

	if(Auth::check() && Auth::user()->id == $userobj->id) {
		return View::make("user.home", array("title" => "Your Profile & Activity", "ownpage" => true, "user" => $userobj, "javascript" => array("profile", "home")));
	} else {
		return View::make("user.home", array("title" => $userobj->username." Profile & Activity", "ownpage" => false, "user" => $userobj, "javascript" => array("profile", "home")));
	}
});

// Admin home
Route::get("admin", array('before' => 'admin', function() {
	$log = Adminlog::with("user")->order_by("created_at", "desc")->paginate(30);
	$modqueue = Modqueue::with("user")->order_by("created_at", "asc")->paginate(30);
	return View::make("admin.home", array("title" => "Admin", "javascript" => array("admin"), "log" => $log, "modqueue" => $modqueue));
}));

// Admin - Migrating from the website
Route::get("admin/database/migrate", array("before" => "admin", function() {
	$database = new Laravel\CLI\Tasks\Migrate\Database;
	$resolver = new Laravel\CLI\Tasks\Migrate\Resolver($database);
	$migrator = new Laravel\CLI\Tasks\Migrate\Migrator($resolver, $database);
	$migrator->run();
}));

// Admin routes (no real need to seperate, just to keep nice)
Route::controller(array('admin.user', 'admin.pages', 'admin.news', 'admin.maps', 'admin.faq', 'admin.modqueue', 'admin.comments', 'admin.matches'));

//Routes are checked in the order in which they are listed here
//Since this one is a tad demanding, make sure it ALWAYS remains at the bottom
Route::get("(:any)", function($slug) {
	$custom_page = DB::table("pages")->where("url_slug", "=", $slug)->first();
	if($custom_page) {
			return View::make("pages.custom", array("custom_page" => $custom_page, "title" => $custom_page->title));
	}
	else{
		return Response::error('404');
	}
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('403', function()
{
	return Response::error('403');
});

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

Event::listen('admin', function($module, $action, $target = null, $text = "") {
	if(is_array($text)) $text = json_encode($text);
	$data = array("user_id" => Auth::user()->id, "module" => $module, "action" => $action, "target" => $target, "text" => $text);
	Adminlog::create($data);
});

Event::listen("eloquent.saving", function($model) {
	// Make a slug based on slugfield
	if($model->slugfield && !$model->slug) {
		// Try to find an un-used slug
		$i = 0;
		$slug;
		while(true) {
			$slug = Str::limit(Str::slug($model->{$model->slugfield}), 200-(strlen($i)+1), "");
			if($i > 0) {
				$slug .= "-".$i;
			}
			if(!DB::table($model->table())->where_slug($slug)->first()) {
				break;
			}
			$i++;
		}
		$model->slug = $slug;
	}
});

// Update message thread's updated_at to include last and update unread status
Event::listen("eloquent.created: Message_Message", function($model) {
	// For some reason $model->thread doesn't work, so don't bother trying to do that
	$thread = Message_Thread::find($model->message_thread_id);
	$thread->updated_at = "test"; // Need to mark model as dirty
	$thread->save();
	// Updating unread status, see notes at controllers/messages.php get_view
	DB::table("message_users")->where_message_thread_id($thread->id)->update(array("unread" => 1));
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in "before" and "after" filters are called before and
| after every request to your application, and you may even create other
| filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	if(Request::foundation()->getRootUrl() == "http://majorleaguemining.com") {
		return Redirect::to(str_replace("majorleaguemining.com", "majorleaguemining.net", URI::full()));
	}
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});
Route::filter('admin', function() {
	if (Auth::guest() or !Auth::user()->admin) {
		return Response::error('403');
	}
});