<?php
class Message_Message extends Eloquent {

	/* Relationships */
	public function user() {
		return $this->belongs_to("User");
	}
	public function thread() {
		return $this->belongs_to("Message_Thread");
	}

	/* Parse message markdown */
	public function set_message($text) {
		Bundle::start("sparkdown");
		$html = Sparkdown\Markdown($text); // Handle markdown
		$this->set_attribute("message", IoC::resolve("HTMLPurifier")->purify($html));
	}
}