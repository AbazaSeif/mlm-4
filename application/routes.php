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
Route::controller(array('account', "imgmgr"));
Route::controller(array('admin.user', 'admin.pages'));

Route::get('/', function() {
	return View::make('home.index');
});
Route::get("login", "account@login");

Route::get("user", function() {
	return View::make("user.home", array('username' => 'username'));
});

Route::get("admin", array('before' => 'admin', function() {
	return View::make("admin.home");
}));

//Routes are checked in the order in which they are listed here
//Since this one is a tad demanding, make sure it ALWAYS remains at the bottom
Route::get("(:any)", function($slug) {
	$custom_page = DB::first("select * from pages where url_slug = ?", array($slug)); //dunno if $slug needs some escape-work done to prevent SQL injection or if that's all automatic
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

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

Event::listen('admin', function($module, $action, $target, $text) {
	if(is_array($text)) $text = json_encode($text);
	$data = array("user_id" => Auth::user()->id, "module" => $module, "action" => $action, "target" => $target, "text" => $text);
	Adminlog::create($data);
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
	// Do stuff before every request to your application...
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
		return Response::error('404');
	}
});