<?php
class Imgmgr_Controller extends Base_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "auth");
	}
	
	public function get_index() {
		$images = Image::paginate(50);
		return View::make("images.viewer", array("images" => $images));
	}
	public function post_upload() {
		if(!Auth::user()->admin) {
			return Response::error('404');
		}
		$input = Input::all();
		if(strlen($input["title"]) == 0) {
			$input["title"] = $input["uploaded"]["name"];
		}
		$validation = Validator::make($input, array("uploaded" => "image|max:1000"));
		if($validation->passes()) {
			$image = Image::create(array("file" => $input["uploaded"], "filename" => "title", "type" => "upload"));
			Messages::add("success", "Image uploaded!");
			return Redirect::to_action("imgmgr");
		} else {
			return Redirect::to_action("imgmgr")->with_input()->with_errors($validation);
		}
	}
}