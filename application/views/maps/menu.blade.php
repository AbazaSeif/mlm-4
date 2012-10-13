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

@if (URI::is('maps') || URI::is('maps/filter'))

<ul id="multiview-controler" class="submenu nav nav-pills">
	<li class="disabled"><a href="#">Views:</a></li>
	<li data-multiview="grid"><a href="#">Grid</a></li>
	<li data-multiview="list"><a href="#">List</a></li>
	<li data-multiview="big"><a href="#">Big</a></li>
</ul>

@elseif (URI::is('map/*') || URI::is('maps/edit/*') || URI::is('maps/edit_link/*') || URI::is('maps/delete_link/*') || URI::is('maps/delete_image/*') )
@if(Auth::check() && Auth::user()->admin)
<ul class="submenu nav nav-pills">
	<li class="disabled"><a href="#">Actions:</a></li>
	<li>{{ HTML::link_to_action("admin@maps@view", "Moderate Map", array($map->id)) }}</li>
	<li>{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}</li>
@if (URI::is('maps') || URI::is('maps/view/*'))
@else
	<li>{{ HTML::link_to_action("maps@view", "Back to Map", array($map->id, $map->slug)) }}</li>
@endif
</ul>
	@elseif($is_owner)
<ul class="submenu nav nav-pills">
	<li class="disabled"><a href="#">Actions:</a></li>
	<li>{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}</li>
</ul>
@else
@endif

@else
@endif