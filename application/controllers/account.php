<?php

class Account_Controller extends Base_Controller {

	public $restful = true;

	public function get_login() {
		return View::make('pages.login');
	}
	public function post_login() {
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
//					if(Auth::attempt(array("identity" => $identity))) {
					if(false) {
						Messages::add("success", "Welcome back ".Auth::user()->username."!");
						return Redirect::home();
					} else {
						Messages::add("success", $identity);
						// Store identity in session, redirect to registration form
						return Redirect::home();
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
}