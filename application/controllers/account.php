<?php

class Account_Controller extends Base_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->filter("before", "auth")->except(array("login", "callback", "register"));
		// Asking for user to access logout? Irony is strong here.
		$this->filter("before", "csrf")->on("post")->only("del_openid");
	}
	
	public $restful = true;
	
	public function get_index() {
		$openids = Auth::user()->openid;
		return View::make("pages.account", array("title" => "Account", "openids" => $openids));
	}
	/* Public methods -- Login */
	public function get_login() {
		if(Auth::check()) {
			return Redirect::home();
		}
		return View::make('pages.login', array('title' => 'Login', "javascript" => array("login")));
	}
	public function post_login() {
		$openid = new LightOpenID(Config::get('openid.host'));
		try {
			$openid->identity = Input::get('openid_identifier');
			$openid->returnUrl = URL::to_action("account@callback");
			return Redirect::to($openid->authUrl());
		} catch(Exception $e) {
			Messages::add('error', $e->getMessage());
			if(Auth::check()) {
				return Redirect::to_action("account");
			} else {
				return Redirect::to_action("account@login");
			}
		}
	}
	public function get_callback() {
		$openid = new LightOpenID(Config::get('openid.host'));
		if($openid->mode) {
			if($openid->mode == 'cancel') {
				Messages::add('error', 'Login cancelled');
				return Redirect::home();
			} else {
				if($openid->validate()) {
					$identity = $openid->identity;
					if(Auth::guest()) {
						if(Auth::attempt(array("identity" => $identity))) {
							Messages::add("success", "Welcome back ".Auth::user()->username."!");
							return Redirect::home();
						} else {
							Session::put("openid-identity", $identity);
							return Redirect::to_action("account@register");
						}
					} else {
						if(Openid::where_identity($identity)->count() == 0) {
							Auth::user()->openid()->insert(array("identity" => $identity));
							Messages::add("success", "This login has been added");
							return Redirect::to_action("account");
						} else {
							Messages::add("error", "This login is already being used");
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
	public function get_register() {
		if(Auth::check()) {
			return Redirect::home();
		}
		if(!Session::has("openid-identity")) {
			Messages::add("warning", "Session timeout!");
			return Redirect::to_action("account@login");
		}
		return View::make('pages.register');
	}
	public function post_register() {
		if(Auth::check()) {
			return Redirect::home();
		}
		if(!Session::has("openid-identity")) {
			Messages::add("warning", "Session timeout!");
			return Redirect::to_action("account@login");
		}
		$validation_rules = array(
			'username'  => 'required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users',
			'mc_username' => 'required|min:2|max:16|match:/^[a-z0-9_]*$/i|unique:users'
		);
		$validation = Validator::make(Input::all(), $validation_rules);
		if($validation->passes()) {
			$user = new User(array("username" => Input::get("username"), "mc_username" => Input::get("mc_username")));
			$user->save();
			
			$openid = new Openid(array("identity" => Session::get("openid-identity")));
			$user->openid()->insert($openid);
			
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
		Messages::add("success", "You have logged out. Good Bye.");
		return Redirect::home();
	}
	/* Account - remove openid */
	public function post_del_openid() {
		if(!($oid = Input::get("oid"))) {
			return Redirect::to_action("account");
		}
		if(Auth::user()->openid()->count() <= 1) {
			Messages::add("error", "You can't delete the only way to login");
			return Redirect::to_action("account");
		}
		$openid = Openid::find($oid);
		if(!$openid || $openid->user_id != Auth::user()->id) {
			return Redirect::to_action("account");
		}
		$openid->delete();
		Messages::add("success", "Openid method deleted!");
		return Redirect::to_action("account");
	}
}