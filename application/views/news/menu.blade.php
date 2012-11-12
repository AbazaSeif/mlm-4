<nav id="pagemenu">
	<ul class="nav nav-tabs">
		<li class="rside btn-info borderless" >{{ HTML::link("news/feed/atom", "ATOM", array("class" => "white")) }}</li>
		<li class="rside btn-warning" >{{ HTML::link("/news/feed/rss", "RSS", array("class" => "white")) }}</li>
		<li class="rside" >{{ HTML::link("#", "Subscribe:", array("class" => "disabled")) }}</li>
	</ul>
</nav>