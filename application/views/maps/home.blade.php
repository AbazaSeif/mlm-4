@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content" class="maps">
	<div id="multivew-controler" style="display:none">
		<ul>
			<li>View</li>
				<li>Grid</li>
				<li>details</li>
				<li>table</li>
			<li>Sort by</li>
				<li>Name</li>
				<li>Players</li>
				<li>Rank</li>
		</ul>
	</div>
<div id="multiview">
<ul class="grid">
@foreach ($maps->results as $map)
	<li>
		<div class="mv-image">
			<img src="http://placehold.it/284x160&text=Map+image" alt="map image"/>
		</div>
		<div class="mv-details">
			<h4>Map title blah</h4>
			<p>Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor </p>
		</div>
		<div class="mv-meta">
		</div>
	</li>
@endforeach
</ul>
</div>
</div>
@endsection