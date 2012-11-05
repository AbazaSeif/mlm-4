<nav id="pagemenu">
	<ul class="nav nav-tabs">
		<li>{{ HTML::link('/matches', 'Match Home'); }}</li>
		<li>{{ HTML::link("matches/list", "Match List") }}</li>
		@if (Auth::check())
		<li {{ URI::is('matches/new') ? 'class="rside active"' : 'class="rside btn-inverse borderless"' }}>{{ HTML::link("matches/new", "New Match",array("class" => "white") ) }}</li>
		@endif
	</ul>
</nav>