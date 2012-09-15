<?php
class Admin_Modqueue_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("delete"));
	}

	public function get_index() {
		return Redirect::to("admin");
	}

	public function get_view($id) {
		$modqueue = Modqueue::find($id);
		return View::make("admin.modqueue.view", array("item" => $modqueue, "title" => "Modqueue | Admin"));
	}

	//delete
	public function get_delete($id) {
		$modqueue = Modqueue::find($id);
		if(!$modqueue) {
			Messages::add("error", "Modqueue item not found");
			return Redirect::to_action("admin");
		}
		return View::make("admin.modqueue.delete", array("item" => $modqueue, "title" => "Delete | Modqueue | Admin"));
	}
	public function post_delete($id) {
		$modqueue = Modqueue::find($id);
		if(!$modqueue) {
			Messages::add("error", "Modqueue item not found");
			return Redirect::to_action("admin");
		}
		$modqueue->delete();
		Event::fire("admin", array("modqueue", "delete", $modqueue->id));
		Messages::add("success", "Modqueue item deleted!");
		return Redirect::to_action("admin");
	}
}
?>