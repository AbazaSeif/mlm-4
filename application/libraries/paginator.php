<?php 

class Paginator extends Laravel\Paginator {

	/**
	 * The "dots" element used in the pagination slider.
	 *
	 * @var string
	 */
	protected $dots = '<li class="disabled"><a class="dots">...</a></li>';

	/**
	 * Create the HTML pagination links.
	 *
	 * Typically, an intelligent, "sliding" window of links will be rendered based
	 * on the total number of pages, the current page, and the number of adjacent
	 * pages that should rendered. This creates a beautiful paginator similar to
	 * that of Google's.
	 *
	 * Example: 1 2 ... 23 24 25 [26] 27 28 29 ... 51 52
	 *
	 * If you wish to render only certain elements of the pagination control,
	 * explore some of the other public methods available on the instance.
	 *
	 * <code>
	 *		// Render the pagination links
	 *		echo $paginator->links();
	 *
	 *		// Render the pagination links using a given window size
	 *		echo $paginator->links(5);
	 * </code>
	 *
	 * @param  int     $adjacent
	 * @return string
	 */
	public function links($adjacent = 3) {
		/* Modifications:
		 * return -- added <ul></ul>
		 */
		if ($this->last <= 1) return '';

		// The hard-coded seven is to account for all of the constant elements in a
		// sliding range, such as the current page, the two ellipses, and the two
		// beginning and ending pages.
		//
		// If there are not enough pages to make the creation of a slider possible
		// based on the adjacent pages, we will simply display all of the pages.
		// Otherwise, we will create a "truncating" sliding window.
		if ($this->last < 7 + ($adjacent * 2)) {
			$links = $this->range(1, $this->last);
		} else {
			$links = $this->slider($adjacent);
		}

		$content = $this->previous().' '.$links.' '.$this->next();

		return '<div class="pagination"><ul>'.$content.'</ul></div>';
	}

	/**
	 * Create a chronological pagination element, such as a "previous" or "next" link.
	 *
	 * @param  string   $element
	 * @param  int      $page
	 * @param  string   $text
	 * @param  Closure  $disabled
	 * @return string
	 */
	protected function element($element, $page, $text, $disabled) {
		/* Modiications:
		 * Class = element (previous, next)
		 * If disabled, only add another class (still make a link)
		 * Add <li> wrapper, which gets the class
		 */
		$class = "{$element}";

		if (is_null($text)) {
			$text = Lang::line("pagination.{$element}")->get($this->language);
		}

		// Each consumer of this method provides a "disabled" Closure which can
		// be used to determine if the element should be a span element or an
		// actual link. For example, if the current page is the first page,
		// the "first" element should be a span instead of a link.
		if ($disabled($this->page, $this->last)) {
			$class .= " disabled";
		}
		return "<li class=\"{$class}\">".$this->link($page == 0 ? 1 : ($page > $this->last ? $this->last : $page), $text, null)."</li>";
	}


	/**
	 * Build a range of numeric pagination links.
	 *
	 * For the current page, an HTML span element will be generated instead of a link.
	 *
	 * @param  int     $start
	 * @param  int     $end
	 * @return string
	 */
	protected function range($start, $end)
	{
		/* Modifications:
		 * In case page == page, only change class 
		 * li wrapper, which gets the class
		 */
		$pages = array();

		// To generate the range of page links, we will iterate through each page
		// and generate a link for the page. If it's the current page add active
		// class to wrapping li element
		for ($page = $start; $page <= $end; $page++)
		{
			$class = null;
			if ($this->page == $page) {
				$class = "active";
			}
			$pages[] = "<li".($class ? " class=\"{$class}\"":"").">".$this->link($page, $page, null)."</li>";
		}

		return implode(' ', $pages);
	}

}