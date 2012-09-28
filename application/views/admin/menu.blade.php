<nav id="pagemenu">
	<ul class="nav nav-tabs">
		<li {{ URI::is('admin') ? 'class="active"' : '' }}>{{ HTML::link("admin", "Admin Home") }}</li>
		<li {{ URI::is('admin/news') ? 'class="active"' : '' }}>{{ HTML::link("admin/news", "News") }}</li>
		<li {{ URI::is('admin/tournaments') ? 'class="active"' : '' }}>{{ HTML::link("admin/tournaments", "Tournaments") }}</li>
		<li {{ URI::is('admin/matches') ? 'class="active"' : '' }}>{{ HTML::link("admin/matches", "Matches") }}</li>
		<li {{ URI::is('admin/teams') ? 'class="active"' : '' }}>{{ HTML::link("admin/teams", "Teams") }}</li>
		<li {{ URI::is('admin/maps') ? 'class="active"' : '' }}>{{ HTML::link("admin/maps", "Maps") }}</li>
		<li {{ URI::is('admin/pages') ? 'class="active"' : '' }}>{{ HTML::link("admin/pages", "Pages") }}</li>
		<li {{ URI::is('admin/user') ? 'class="active"' : '' }}>{{ HTML::link("admin/user", "Users") }}</li> 
		<li {{ URI::is('admin/comments*') ? 'class="active"' : '' }}>{{ HTML::link("admin/comments", "Comments") }}</li>
		<li><a onClick="MLM.images.open(); return false;" href="#" >Images</a></li>
		<li {{ URI::is('admin/faq') ? 'class="active"' : '' }}>{{ HTML::link("admin/faq", "FAQ") }}</li>
	</ul>
</nav>