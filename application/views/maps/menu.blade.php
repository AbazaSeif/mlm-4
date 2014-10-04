<nav id="pagemenu" class="clearfix">
	<ul class="nav nav-tabs">
		<li {{ (Input::get('search')) ? 'class="active"' : ''}}><a href="{{ action("maps@filter") }}?search=1" data-toggle="collapse" data-target="#map-search" onClick="return false;"><i class="icon-filter"></i></a></li>
		<li {{ (Input::get('featured') == 'true' && !Input::get('search')) ? 'class="active"' : ''}}>{{ HTML::link('maps/filter?featured=true', 'Featured Maps') }}</li>
		<li {{ (Input::get('order') == 'best' && !Input::get('search')) ? 'class="active"' : ''}}>{{ HTML::link("maps/filter?order=best", "Highest ranked") }}</li>
		<li {{ (Input::get('order') == 'newest' && !Input::get('search')) ? 'class="active"' : ''}}>{{HTML::link("maps/filter?order=newest", "Newest") }}</li>		
		<li {{ (Input::get('all') == 1) ? 'class="active"' : ''}}>{{HTML::link("maps?all=1", "All") }}</li>		
		<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories <b class="caret"></b></a>
				<ul class="dropdown-menu">
					@foreach(Config::get("maps.types") as $cat_short => $category)
						<li {{ (Input::get('type') == $cat_short) ? 'class="active"' : ''}}>{{ HTML::link("maps/filter/?type={$cat_short}", $category) }} </li>
					@endforeach
				</ul>
			</li>
		<li {{ URI::is('maps/new') && !Input::get('search') ? 'class="rside active"' : 'class="rside btn-inverse borderless"' }}>{{ HTML::link("maps/new", "New Map", array("class" => "white")) }}</li>
		@if (Auth::check())
		<li {{ Input::get("ownmaps") == true && !Input::get('search') ? 'class="rside active"' : 'class="rside"' }}><a href="{{ URL::to("maps/filter/?ownmaps=1") }}">Your Maps</a></li>
		@endif
	</ul>
	<?php Form::$idpre = "map-search-"; ?>
	{{ Form::open("maps/filter", "GET", array("id"=> "map-search", "class" => "form clearfix menusearch collapse".(Input::get('search') || Input::get('all') == 1 ? ' in' : ''), "data-cleanup" => true)) }}
		<hr class="spacer" />
		<div class="row">
			<div class="span8">
				{{ Form::field("text", "title", "Title", array(Input::get("title"), array("class" => "span8"))) }}
			</div>
			<div class="span4">
				{{ Form::field("select", "type", "Map type", array(array_merge(array("" => "--------------"), Config::get("maps.types")), Input::get("type"), array("class" => "span4"))) }}
			</div>
		</div>
		<div class="row">
			<div class="span3">
				{{ Form::field("text", "teamcount", "Team count", array(Input::get("teamcount"), array("class" => "span3"))) }}
			</div>
			<div class="span3">
				{{ Form::field("text", "teamsize", "Team size", array(Input::get("teamsize"), array("class" => "span3"))) }}
			</div>
			<div class="span3">
				{{ Form::field("text", "mcversion", "Minecraft version", array(Input::get("mcversion"), array("class" => "span3", "title" => "Can be partial, eg 1.4"))) }}
			</div>
			<div class="span3">
				{{ Form::field("select", "order", "Order by", array(array("newest" => "Newest", "oldest" => "Oldest", "best" => "Best", "worst" => "Worst"), Input::get("order", "newest"), array("class" => "span3"))) }}
			</div>
		</div>
		<div class="row">
			<div class="span8">
				<?php
					$fields = array(
						Form::labelled_checkbox("featured", "Featured maps", true, Input::get("featured"))
					);
					if(Auth::check()) {
						$fields[] = Form::labelled_checkbox("ownmaps", "Your Maps", true, Input::get("ownmaps"));
					}
					echo Form::field_list(null, $fields);
				?>
			</div>
			<div class="span4">
				{{ Form::submit("Search", array("class" => "btn-primary pull-right", "name" => "search", "value" => true)) }}
				{{ Form::reset("Reset", array("class" => "pull-right")) }}
			</div>
		</div>
	{{ Form::close() }}
</nav>

@if ($menu == "multiview")

<ul id="multiview-controller" class="submenu nav nav-pills">
	<li class="disabled"><a href="#">Views:</a></li>
	<li data-multiview="grid"><a href="#" title="Map Image and title">Grid</a></li>
	<li data-multiview="big"><a href="#" title="Map Image and all details">Big</a></li>
	<li data-multiview="list"><a href="#" title="Only details">List</a></li>
</ul>

@elseif ($menu == "map" || $menu == "mapedit")
	@if(Auth::check() && Auth::user()->admin || $is_owner)
	<ul class="submenu nav nav-pills">
		<li class="disabled"><a href="#">Actions:</a></li>
		@if(Auth::check() && Auth::user()->admin)
			<li>{{ HTML::link_to_action("admin@maps@view", "Moderate Map", array($map->id)) }}</li>
		@endif
		@if($is_owner || (Auth::check() && Auth::user()->admin))
			<li>{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}</li>
		@endif
		@if ($menu == "mapedit")
			<li>{{ HTML::link_to_action("maps@view", "Back to Map", array($map->id, $map->slug)) }}</li>
		@endif
	</ul>
	@endif
@elseif ($menu == "new")
@endif