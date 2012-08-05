@layout("layout.main")

@section("content")
	<nav id="pagemenu">
		<ul class="nav nav-tabs">
			<li>{{ HTML::link("admin", "Admin Home") }}</li>
			<li>{{ HTML::link("admin/news", "News") }}</li>
			<li>{{ HTML::link("admin/tournaments", "Tournaments") }}</li>
			<li>{{ HTML::link("admin/maps", "Maps") }}</li>
			<li>{{ HTML::link("admin/teams", "Teams") }}</li>
			<li>{{ HTML::link("admin/pages", "Pages") }}</li>
			<li>{{ HTML::link("admin/user", "Users") }}</li> 
			<li class="dropdown">
    		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Comments
        	<b class="caret"></b>
      		</a>
    		<ul class="dropdown-menu">
      		<li>{{ HTML::link("admin/news/comments", "News") }}</li>
      		<li>{{ HTML::link("admin/maps/comments", "Maps") }}</li>
    		</ul>
  			</li>
			<li><a onClick="MLM.images.open(); return false;" href="#" >Images</a></li>
		</ul>
	</nav>
@endsection
