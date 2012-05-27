<?php

class Account_Controller extends Base_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->filter("before", "auth")->only("logout");
		// Asking for user to access logout? Irony is strong here.
	}
	
	public $restful = true;
	
	/* Public methods -- Login */
	public function get_login() {
		if(Auth::check()) {
			return Redirect::home();
		}
		return View::make('pages.login', array('title' => 'Login'));
	}
	public function post_login() {
		if(Auth::check()) {
			return Redirect::home();
		}
		$openid = new LightOpenID(Config::get('openid.host'));
		try {
			$openid->identity = Input::get('openid_identifier');
			$openid->returnUrl = URL::to_action("account@callback");
			return Redirect::to($openid->authUrl());
		} catch(Exception $e) {
			Messages::add('error', $e->getMessage());
			return Redirect::to_action("account@login");
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
					if(Auth::attempt(array("identity" => $identity))) {
						Messages::add("success", "Welcome back ".Auth::user()->username."!");
						return Redirect::home();
					} else {
						Session::put("openid-identity", $identity);
						return Redirect::to_action("account@register");
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
}