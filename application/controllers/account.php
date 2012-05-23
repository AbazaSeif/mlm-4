<?php

class Account_Controller extends Base_Controller {

	public $restful = true;

	public function get_login() {
		return View::make('pages.login');
	}

}