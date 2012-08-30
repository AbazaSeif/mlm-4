<?php
class Admin_Faq_Controller extends Admin_Controller {
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
		$this->filter("before", "csrf")->on("post")->only(array("edit", "delete"));
	}

	public function get_index() {
		$faq = DB::table("faq")->order_by("id", "desc")->get(array("id", "question", "answer", "created_at"));
		return View::make("admin.faq.list", array("faq" => $faq, "title" => "FAQ | Admin"));
	}

	// Edit
	public function get_edit($id) {
		$faq = Faq::find($id);
		if(!$faq) {
			Messages::add("error", "Question not found");
			return Redirect::to_action("admin.faq");
		}
		return View::make("admin.faq.form", array("title" => "Edit ".e($faq->title)." | FAQ | Admin", "faq" => $faq));
	}
	public function post_edit($id) {
		$faq = Faq::find($id);
		if(!$faq) {
			Messages::add("error", "Question not found");
			return Redirect::to_action("admin.faq");
		}
		$validation_rules = array(
			"question"       => "required|max:128",
			"answer"     => "required",
		);
		$input = Input::all();
		$validation = Validator::make($input, $validation_rules);
		if($validation->passes()) {
			$faq->question       = $input["question"];
			$faq->answer     = $input["answer"];
			$changed = array_keys($faq->get_dirty());
			if($faq->save()) {
				Event::fire("admin", array("faq", "edit", $faq->id, $changed));
				Messages::add("success", "FAQ updated!");
				return Redirect::to_action("admin.faq");
			} else {
				Messages::add("error", "Failed to save");
				return Redirect::to_action("admin.faq@edit")->with_input()->with_errors($validation);
			}
		} else {
			return Redirect::to_action("admin.faq@edit", array($id))->with_input()->with_errors($validation);
		}
	}

	// Delete form. DO NOT EVER DO ACTUAL DELETEION IN A GET METHOD
	public function get_delete($id) {
		$faq = Faq::find($id);
		if(!$faq) {
			Messages::add("error", "Question not found");
			return Redirect::to_action("admin.faq");
		}
		return View::make("admin.faq.delete", array("title" => "Delete ".e($faq->title)." | FAQ | Admin", "faq" => $faq));
	}
	// Deletion
	public function post_delete($id) {
		$faq = Faq::find($id);
		if(!$faq) {
			Messages::add("error", "Question not found");
			return Redirect::to_action("admin.faq");
		}
		$faq->delete();
		Event::fire("admin", array("faq", "delete", $faq->id));
		Messages::add("success", "Question deleted!");
		return Redirect::to_action("admin.faq");
	}
}
?>