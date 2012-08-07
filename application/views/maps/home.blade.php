@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content" class="maps">
<ul id="views">
@foreach ($maps->results as $map)
	<li>
		<div class="map-image">
			<img src="http://placehold.it/284x160&text=Map+image" alt="map image"/>
		</div>
		<div class="map-details">
			<h4>Map title blah</h4>
			<p>Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor </p>
		</div>
		<div class="map-meta">
		</div>
	</li>
@endforeach
</ul>
</div>
@endsection