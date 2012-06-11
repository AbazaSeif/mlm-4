<?php

// For /admin see routes.php, this is base for admin controllers

class Admin_Controller extends Base_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "admin"); // Require admin user
	}
}