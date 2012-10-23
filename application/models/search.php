<?php
/*
A class for searching stuff... yeah.
The 'actual searching' is done in the function 'RawSearch' which takes a query (string) and an array of tables to search for as input
Once sorted, RawSearch sorts the results in 'SortArrayByColumn' which takes the results (array), maxhits (maximum number of search hits) and the column name which contians the number of search hits
SortArrayByColumn then sorts it so that the result with most results is at the top

Talk to edh649 if you need more clarification on the back-end of the search :)
*/
class Search {
	private static function SortArrayByColumn($array, $maxhits, $columnname) {
		$Arrayi = 0; //What array #. are we currently on?
		$output = array();
		for ($i = $maxhits; $i >= 0; $i--) { //Start from maxhits down (most hits at top of array)
			foreach ($array as $item) {
				if ($item->$columnname == $i) {
					$output[$Arrayi] = Search::AddSearchResultTableJoins($item);
					$Arrayi++;
				}
			}
		}
		$perpage = 50;
		return Paginator::make($output, count($output), $perpage);
	}

	private static function AddSearchResultTableJoins($item) {
		$output = $item;
		switch ($item->searchresulttype) {
			case "users":
				$output = User::find($item->id);
				break;

			case "maps":
				$output = Map::find($item->id);
				break;

			case "news":
				$output = News::find($item->id);
				break;

			case "matches":
				$output = Match::find($item->id);
				break;

			case "comments":
				$output = Comment::find($item->id);
				break;

			default:
				$output = $item;
				break;
		}
		$output->searchhitcount = $item->searchhitcount;
		return $output;
	}

	private static function SearchOneTable($query, $tablename, $columns) {
		//Convert the single table into an array of tables (with 1 table array in it (and it's name))
		return Search::RawSearch($query, array(array(
			"name" => $tablename,
			"columns" => $columns,
			)));
	}

	private static function RawSearch($query, $tablenames) {
		//Set the words we're searching for, split by spaces
		$words = explode(' ', $query);

		$highesthitcount = 0;
		$tablenumbermodifier = 0;
		$results = array();

		foreach ($tablenames as $table) {
			foreach ($table["columns"] as $column) {
				foreach ($words as $word) {
					$hits = DB::table($table["name"])->where($column, 'LIKE', "%".$word."%")->get();
					foreach($hits as $item) {
						if (array_key_exists(($item->id + $tablenumbermodifier), $results))	{
							$results[$item->id + $tablenumbermodifier]->searchhitcount += 1;

							if ($results[$item->id + $tablenumbermodifier]->searchhitcount > $highesthitcount) {
								$highesthitcount = $results[$item->id + $tablenumbermodifier]->searchhitcount;
							}
						}
						else {
							$results[$item->id + $tablenumbermodifier] = $item;
							//Add some extra to each result so we can found out stuff later
							$results[$item->id + $tablenumbermodifier]->searchhitcount = 1;					//How many hits did we get from the query
							$results[$item->id + $tablenumbermodifier]->searchresulttype = $table["name"];	//What type of result is it (map, news, users etc.)

							if ($highesthitcount < 1) $highesthitcount = 1;
						}
					}
				}
			}
			//This is so that if we have multiple tables, items are not overridden
			$results = array_values($results);
			$tablenumbermodifier += count($results);
		}
		return Search::SortArrayByColumn($results, $highesthitcount, "searchhitcount");
	}

	public static function SearchUsers($query) {
		$columns = array(
			"username",
			"mc_username",
			);
		return Search::SearchOneTable($query, "users", $columns);
	}

	public static function SearchMaps($query) {
		$columns = array(
			"title",
			"summary",
			"description",
			);
		return Search::SearchOneTable($query, "maps", $columns);
	}

	public static function SearchNews($query) {
		$columns = array(
			"title",
			"summary",
			"content",
			);
		return Search::SearchOneTable($query, "news", $columns);
	}

	public static function SearchMatches($query) {
		$columns = array(
			"mapname",
			"info",
			);
		return Search::SearchOneTable($query, "matches", $columns);
	}

	public static function SearchComments($query) {
		$columns = array(
			"source",
			);
		return Search::SearchOneTable($query, "comments", $columns);
	}

	public static function SearchAll($query) {
		$tables = array(
			$users = array(
				"name" => "users",
				"columns" => array(
					"username",
					"mc_username",
					),
				),
			$maps = array(
				"name" => "maps",
				"columns" => array(
					"title",
					"summary",
					"description",
					),
				),
			$news = array(
				"name" => "news",
				"columns" => array(
					"title",
					"summary",
					"content",
					),
				),
			$matches = array(
				"name" => "matches",
				"columns" => array(
					"mapname",
					"info",
					),
				),
			$comments = array(
				"name" => "comments",
				"columns" => array(
					"source",
					),
				),
			);
		return Search::RawSearch($query, $tables);
	}
}