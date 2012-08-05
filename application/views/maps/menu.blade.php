<nav id="pagemenu">
	<ul class="nav nav-tabs">
		<li>{{ HTML::link("account", "Newest") }}</li>
		<li>{{ HTML::link('user', 'Featured'); }}</li>
		<li>{{ HTML::link("account", "Highest ranked") }}</li>
		<li>{{ HTML::link("account", "Official Maps") }}</li>
		<li class="dropdown">
    		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories
        	<b class="caret"></b>
      		</a>
    		<ul class="dropdown-menu">
      		<li>{{ HTML::link("admin/news/comments", "Capture The Wool") }}</li>
      		<li>{{ HTML::link("admin/maps/comments", "Race For The Wool") }}</li>
      		<li>{{ HTML::link("admin/maps/comments", "Destroy the core") }}</li>
    		</ul>
  		</li>
		@if (Auth::check())
		<li class="rside">{{ HTML::link("account", "Your maps") }}</li>
		@endif
	</ul>
</nav>