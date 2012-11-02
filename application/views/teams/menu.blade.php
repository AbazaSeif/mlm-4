<nav id="pagemenu" class="clearfix">
	<ul class="nav nav-tabs">
		<li>{{HTML::link("teams", "All Teams") }}</li>
		<li {{ (Input::get('order') == 'top') ? 'class="active"' : ''}}>{{ HTML::link("teams/filter?order=top", "Ranking") }}</li>
		<li {{ (Input::get('order') == 'newest') ? 'class="active"' : ''}}>{{HTML::link("teams/filter?order=newest", "Newest") }}</li>
		<li {{ URI::is('teams/new') ? 'class="rside active"' : 'class="rside btn-info"' }}>{{ HTML::link("teams/new", "New Team") }}</li>
	</ul>
</nav>