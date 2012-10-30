<nav id="pagemenu">
	<ul class="nav nav-tabs">
		<li>{{ HTML::link('/matches', 'Match Home'); }}</li>
		<li>{{ HTML::link("matches/list", "Match List") }}</li>
		@if (Auth::check())
		<li {{ URI::is('matches/new') ? 'class="rside active"' : 'class="rside btn-info"' }}>{{ HTML::link("matches/new", "New Match") }}</li>
		@endif
	</ul>
</nav>