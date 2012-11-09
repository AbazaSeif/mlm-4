<a href="#" id="show-adminmenu">Admin Menu</a>
<div id="adminmenu">
	<ul>
		<li {{ URI::is('admin') ? 'class="active"' : '' }}><i class="icon-home"></i> {{ HTML::link("admin", "Admin Home") }}</li>
		<li {{ URI::is('admin/news') ? 'class="active"' : '' }}><i class="icon-rss"></i> {{ HTML::link("admin/news", "News") }}</li>
		<li {{ URI::is('admin/matches') ? 'class="active"' : '' }}><i class="icon-bullhorn"></i> {{ HTML::link("admin/matches", "Matches") }}</li>
		<li {{ URI::is('admin/teams') ? 'class="active"' : '' }}><i class="icon-globe"></i> {{ HTML::link("admin/teams", "Teams") }}</li>
		<li {{ URI::is('admin/maps') ? 'class="active"' : '' }}><i class="icon-map-marker"></i> {{ HTML::link("admin/maps", "Maps") }}</li>
		<li {{ URI::is('admin/pages') ? 'class="active"' : '' }}><i class="icon-link"></i> {{ HTML::link("admin/pages", "Pages") }}</li>
		<li {{ URI::is('admin/user') ? 'class="active"' : '' }}><i class="icon-group"></i> {{ HTML::link("admin/user", "Users") }}</li> 
		<li {{ URI::is('admin/comments*') ? 'class="active"' : '' }}><i class="icon-comments"></i> {{ HTML::link("admin/comments", "Comments") }}</li>
		<li><i class="icon-picture"></i> <a onClick="MLM.images.open(); return false;" href="#" >Images</a></li>
		<li {{ URI::is('admin/faq') ? 'class="active"' : '' }}><i class="icon-question-sign"></i> {{ HTML::link("admin/faq", "FAQ") }}</li>
	</ul>
</div>