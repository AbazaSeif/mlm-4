<?php
class Test_Controller extends Base_Controller {
	public $restful = true;

	public function get_test1() {
		return View::make("tests.test1");
	}
	public function post_test1() {
		$uniq = rand();
		Log::test1(print_r(array($uniq, Input::all(), ), true));
		Messages::add("success", "Test portion {$uniq}!");
		return View::make("tests.results", array("uniq" => $uniq));
	}
}