<?php
class Imgmgr_Controller extends Base_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "auth");
	}
	// Get image manager
	public function get_index() {
		$images = Image::paginate(50);
		return View::make("images.viewer", array("images" => $images));
	}
	// Handle image uploads
	public function post_upload() {
		if(!Auth::user()->admin) {
			return Response::error('404');
		}
		$input = Input::all();
		if(strlen($input["title"]) == 0) { // Just use the filename
			$input["title"] = $input["uploaded"]["name"];
		}
		$validation = Validator::make($input, array("uploaded" => "image|max:1000"));
		if($validation->passes()) {
			$image = Image::create(array("file" => $input["uploaded"], "filename" => $input["title"], "type" => "upload"));
			return json_encode(array("file" => $image->to_array()));
		} else {
			return json_encode(array("error" => $validation->errors->all()));
		}
	}
}