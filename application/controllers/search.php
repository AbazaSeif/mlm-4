<?php

class Search_Controller extends Base_Controller {
	public $restful = true;

	public function __construct() {
		parent::__construct();
	}

	public function get_index() {
		if (!Input::Has('query')) { //if there's no query

		}
		else { //we have a query
			$query = Input::get('query');
			$type = Input::get('type', null);
			switch ($type) {
				case "user":
					$results = Search::SearchUsers($query);
					break;
				case "maps":
					$results = Search::SearchMaps($query);
					break;
				case "news":
					$results = Search::SearchNews($query);
					break;
				case "matches":
					$results = Search::SearchMatches($query);
					break;
				case "comments":
					$results = Search::SearchComments($query);
					break;
				default:
					$results = Search::SearchAll($query);
					$type = null;
					break;
			}
			return View::make("search.list", array("title" => $query." | Search Results", "query" =>  $query, "results" => $results, "type" => $type));
		}
	}

}
?>