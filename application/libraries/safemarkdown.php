<?php
class SafeMarkdown extends Sparkdown\Markdown_Parser {
//	var $no_markup = true;
//	var $no_entities = true;

	static public $self_instance;
	static public $purifier_instance;
	
	static function parse($text) {
		// Markdown
		if (!isset(self::$self_instance)) {
			self::$self_instance = new self;
		}
		$text = self::$self_instance->transform($text); // Handle markdown
		// Cleanup
		if (!isset(self::$purifier_instance)) {
			
			self::$purifier_instance = new HTMLPurifier();
		}
		$text = self::$purifier_instance->purify($text);
		return $text;
	}
	
}