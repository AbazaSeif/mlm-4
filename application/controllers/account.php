<?php

class Account_Controller extends Base_Controller {

	public $restful = true;

	public function get_login() {
		return View::make('pages.login', array('title' => 'Login'));
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
		return View::make('pages.register');
	}
}