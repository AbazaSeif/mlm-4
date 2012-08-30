<?php

class Faq_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();
	}

	//view FAQ
	public function get_index() {
		$faqlist = FAQ::order_by("question", "asc")->paginate(10);
		return View::make("faq.view", array("title" => "FAQ", "faqlist" => $faqlist));
	}

}
?>