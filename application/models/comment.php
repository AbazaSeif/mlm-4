<?php
class Comment extends Eloquent {
	public static $timestamps = true;
	public static $table = "comments";

	public $children = array();

	// Relations
	public function user() {
		return $this->belongs_to("User");
	}
	public function news() {
		return $this->belongs_to("News");
	}
	public function map() {
		return $this->belongs_to("Map");
	}

	/* Setting source will also generate html */
	public function set_source($text) {
		$this->set_attribute("source", $text);

		Bundle::start("sparkdown");
		$html = Sparkdown\Markdown($text); // Handle markdown
		$this->set_attribute("html", IoC::resolve("HTMLPurifier")->purify($html));
	}

}