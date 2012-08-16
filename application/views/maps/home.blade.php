@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content" class="maps">
	<div>
		<ul id="multiview-controler">
			<li data-multiview="grid">Grid</li>
			<li data-multiview="list">List</li>
			<li data-multiview="table">Table</li>
		</ul>
	</div>
<div id="multiview">
<ul class="{{ Cookie::get('multiview', 'grid') }}">
@foreach ($maps->results as $map)
	<li>
		<div class="mv-image">
			<img src="http://placehold.it/284x160&text=Map+image" alt="map image"/>
		</div>
		<div class="mv-details">
			<h4>{{ HTML::link_to_action("maps@view", $map->title, array($map->id, $map->slug)) }}</h4>
			<p>{{ $map->summary }}</p>
		</div>
		<div class="mv-meta">
		</div>
	</li>
@endforeach
</ul>
</div>
</div>
@endsection