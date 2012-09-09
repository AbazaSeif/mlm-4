<nav id="pagemenu" class="clearfix">
	<ul class="nav nav-tabs">
    <li>{{HTML::link("maps", "All") }}</li>
		<li {{ (Input::get('order') == 'newest') ? 'class="active"' : ''}}>{{HTML::link("maps/filter?order=newest", "Newest") }}</li>
    <li {{ (Input::get('order') == 'best') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter?order=best", "Highest ranked") }}</li>
    <li {{ (Input::get('official') == 'true') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter?official=true", "Official Maps") }}</li>
		<li {{ (Input::get('featured') == 'true') ? 'class="active"' : ''}}>{{ HTML::link('maps/filter?featured=true', 'Featured Maps'); }}</li>
		<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories <b class="caret"></b></a>
				<ul class="dropdown-menu">
					@foreach(Config::get("maps.types") as $cat_short => $category)
						<li {{ (Input::get('type') == $cat_short) ? 'class="active"' : ''}}>{{ HTML::link("maps/filter/?type={$cat_short}", $category) }} </li>
					@endforeach
				</ul>
			</li>
		@if (Auth::check())
		<li {{ URI::is('maps/new') ? 'class="rside active"' : 'class="rside"' }}>{{ HTML::link("maps/new", "New Map") }}</li>
		<li {{ Input::get("ownmaps") == true ? 'class="rside active"' : 'class="rside"' }}><a href="{{ URL::to("maps/filter/?ownmaps=1") }}">Your Maps</a></li>
		@endif
	</ul>
</nav>