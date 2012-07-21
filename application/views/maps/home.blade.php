@layout("layout.main")

@section("content")
<div id="content" class="maps">
{{ HTML::link_to_action("maps@new", "New map") }}

<ul>
@foreach ($maps->results as $map)
	<li>{{ HTML::link_to_action("maps@view", $map->title, array($map->id, $map->slug)) }}</li>
@endforeach
</ul>
</div>
@endsection