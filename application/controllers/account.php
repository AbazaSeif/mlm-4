<?php

class Account_Controller extends Base_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->filter("before", "auth")->except(array("login", "callback", "register"));
		// Asking for user to access logout? Irony is strong here.
		$this->filter("before", "csrf")->on("post")->only(array("del_openid", "profile"));
	}
	
	public $restful = true;
	
	/* Account management */
	public function get_index() {
		$openids = Auth::user()->openid;
		return View::make("pages.account", array("title" => "Edit Account & Profile", "openids" => $openids));
	}
	/* Public methods -- Login */
	public function get_login() {
		if(Auth::check()) {
			return Redirect::home();
		}
		if($to_url = strstr(Request::server('http_referer'), URL::base())) {
			if(!strstr($to_url, URL::to("login")) || !strstr($to_url, URL::to_action("account@login"))) {
				Session::put("login_redirect", $to_url);	
			}
		}
		return View::make('pages.login', array('title' => 'Login', "javascript" => array("login")));
	}
	/* Do openid login */
	public function post_login() {
		$openid = new LightOpenID(Config::get('openid.host'));
		try {
			Session::put("login_remember", Input::get("remember"));
			$openid->identity = Input::get('openid_identifier');
			$openid->returnUrl = URL::to_action("account@callback");
			return Redirect::to($openid->authUrl());
		} catch(Exception $e) { // Failed to connect to openid endpoint?
			Messages::add('error', $e->getMessage());
			if(Auth::check()) { // If logged in, redirect to account (probably wanted to add a openid method to account)
				return Redirect::to_action("account");
			} else {
				return Redirect::to_action("account@login");
			}
		}
	}
	/* Openid callback */
	public function get_callback() {
		$openid = new LightOpenID(Config::get('openid.host'));
		if($openid->mode) {
			if($openid->mode == 'cancel') {
				Messages::add('error', 'Login cancelled');
				return Redirect::home();
			} else {
				if($openid->validate()) { // Validate that proper openid loop was done (no rouge openid endpoints)
					$identity = $openid->identity;
					if(Auth::guest()) { // Guest either logs in, or registers
						if(Auth::attempt(array("identity" => $identity, "remember" => Session::get("login_remember") ))) {
							Session::forget("login_remember");
							Messages::add("success", "Welcome back ".Auth::user()->username."!");
							if($redir = Session::get("login_redirect")) {
								Session::forget("login_redirect");
								return Redirect::to($redir);
							} else {
								return Redirect::home();
							}
						} else {
							Session::put("openid-identity", $identity); /* Used when registration is completed */
							return Redirect::to_action("account@register");
						}
					} else { // Already logged in, check if openid identity isn't in use
						if(Openid::where_identity($identity)->count() == 0) {
							Auth::user()->openid()->insert(array("identity" => $identity));
							Messages::add("success", "This login has been added");
							return Redirect::to_action("account");
						} else {
							Messages::add("error", "This login is already being used by another account");
							return Redirect::to_action("account");
						}
					}
				} else {
					Messages::add('error', 'A creeper got stuck in the system, login failed');
					return Redirect::home();
				}
			}
		} else {
			return Redirect::home();
		}
	}
	/* Registration form */
	public function get_register() {
		if(Auth::check()) {
			return Redirect::home();
		}
		if(!Session::has("openid-identity")) { // Make sure user has come here after trying to authendicate
			Messages::add("warning", "Session timeout!");
			return Redirect::to_action("account@login");
		}
		return View::make('pages.register');
	}
	/* Actual registration */
	public function post_register() {
		if(Auth::check()) {
			return Redirect::home();
		}
		if(!Session::has("openid-identity")) {
			Messages::add("warning", "Session timeout!");
			return Redirect::to_action("account@login");
		}
		$countries = require path("app")."countries.php";
		$countries = array_keys($countries);
		$validation_rules = array(
			'username'  => 'required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users',
			'mc_username' => 'required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users',
			"country" => 'in:'.implode(",", $countries),
			"reddit" => 'match:"/^[\w-]{3,20}$/i"', // validation parameters are parsed as csv
			"twitter" => 'match:"/^[\w]{1,15}$/i"',
			"youtube" => 'match:"/^[\w]{3,20}$/i"',
			"webzone" => "url"
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$user = new User(array("username" => Input::get("username"), "mc_username" => Input::get("mc_username")));
			$user->save();
			
			$openid = new Openid(array("identity" => Session::get("openid-identity")));
			$user->openid()->insert($openid);
			
			$profile = new Profile();
			$profile->country = Input::get("country");
			$profile->reddit = Input::get("reddit");
			$profile->twitter = Input::get("twitter");
			$profile->youtube = Input::get("youtube");
			$profile->webzone = Input::get("webzone");

			$user->profile()->insert($profile);

			Auth::login($user->id);
			Session::forget("openid-identity");
			Messages::add("success", "Welcome ".$user->username."!");
			return Redirect::home();
		} else {
			return Redirect::to_action('account@register')->with_input()->with_errors($validation);
		}
	}
	/* Logout */
	public function get_logout() {
		// TODO: Do real logging out in a post method
		Auth::logout();
		Messages::add("success", "You have logged out. See you soon!");
		return Redirect::home();
	}
	/* Account - remove openid */
	public function post_del_openid() {
		if(!($oid = Input::get("oid"))) {
			return Redirect::to_action("account");
		}
		if(Auth::user()->openid()->count() <= 1) { // count() should never < 1
			Messages::add("error", "You can't delete your only way to login!");
			return Redirect::to_action("account");
		}
		$openid = Openid::find($oid);
		if(!$openid || $openid->user_id != Auth::user()->id) {
			return Redirect::to_action("account"); // Openid not in use or is not owned by current user
		}
		$openid->delete();
		Messages::add("success", "Openid method deleted!");
		return Redirect::to_action("account");
	}
	/* Account - Profile */
	public function post_profile() {
		$user = Auth::user();
		$countries = require path("app")."countries.php";
		$countries = array_keys($countries);
		$validation_rules = array( /* All fields are optional */
			'mc_username' => "required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users,mc_username,{$user->id}",
			"country" => 'in:'.implode(",", $countries),
			"reddit" => 'match:"/^[\w-]{3,20}$/i"', // validation parameters are parsed as csv
			"twitter" => 'match:"/^[\w]{1,15}$/i"',
			"youtube" => 'match:"/^[\w]{3,20}$/i"',
			"webzone" => "url"
		);

		$validation = Validator::make(Input::all(), $validation_rules, array("match" => ":attribute isn't a correct username"));
		if($validation->passes()) {
			$user->mc_username = Input::get("mc_username");
			$user->save();
			$profile = $user->profile;
			$profile->country = Input::get("country");
			$profile->reddit = Input::get("reddit");
			$profile->twitter = Input::get("twitter");
			$profile->youtube = Input::get("youtube");
			$profile->webzone = Input::get("webzone");
			$profile->save();

			Messages::add("success", "Profile saved!");
			return Redirect::to_action("account");
		} else {
			return Redirect::to_action("account")->with_input()->with_errors($validation);
		}
	}
}