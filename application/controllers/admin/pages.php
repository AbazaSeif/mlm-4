<?php
class Admin_Pages_Controller extends Admin_Controller {
	
	public $restful = true;
	
	public function get_index() {
		$pages = DB::table("pages")->get(array("id", "title", "url_slug"));
		return View::make('admin.pages.list', array("pages" => $pages));
	}
}