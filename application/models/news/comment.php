<?php
class News_Comment extends Eloquent {
	public static $timestamps = true;

	/* Relations */
	public function user() {
		return $this->belongs_to("User");
	}
	public function news() {
		return $this->belongs_to("News");
	}

	/* Setting source will also generate html */
	public function set_source($text) {
		$this->set_attribute("source", $text);

		Bundle::start("sparkdown");
		$html = Sparkdown\Markdown($text); // Handle markdown
		$this->set_attribute("html", IoC::resolve("HTMLPurifier")->purify($html));
	}
}