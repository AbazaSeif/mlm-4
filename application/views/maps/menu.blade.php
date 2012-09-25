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

<ul id="multiview-controler" class="nav nav-pills">
	<li class="disabled"><a href="#">Views:</a></li>
	<li data-multiview="grid"><a href="#">Grid</a></li>
	<li data-multiview="list"><a href="#">List</a></li>
	<li data-multiview="big"><a href="#">Big</a></li>
</ul>

@elseif (URI::is('maps/view/*') || URI::is('maps/edit/*'))

<ul class="submenu nav nav-pills">
@if(Auth::check() && Auth::user()->admin)
<li class="disabled"><a href="#">Actions:</a></li>
<li>
{{ HTML::link_to_action("admin@maps@view", "Moderate Map", array($map->id)) }}
</li>
<li>
{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}
</li>
<li>
{{ $map->published ? HTML::link_to_action("admin@maps", "Revoke Map", array("unpublish", $map->id)) : HTML::link_to_action("admin@maps", "Approve Map", array("publish", $map->id)) }}
</li>
<li>
{{ $map->featured ? HTML::link_to_action("admin@maps", "Unfeature Map", array("unfeature", $map->id)) : HTML::link_to_action("admin@maps", "Feature Map", array("feature", $map->id)) }}
</li>
<li>
{{ $map->official ? HTML::link_to_action("admin@maps", "Make Map Unofficial", array("unofficial", $map->id)) : HTML::link_to_action("admin@maps", "Make Map Official", array("official", $map->id))}}
</li>
@elseif($is_owner)
<li class="disabled"><a href="#">Actions:</a></li>
<li>
{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}
</li>
@else
@endif
</ul>

@else
Nothing
@endif