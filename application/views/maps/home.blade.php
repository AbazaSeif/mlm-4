@layout("layout.main")

@section("content")
{{ HTML::link_to_action("maps@new", "New map") }}

<ul>
@foreach ($maps->results as $map)
	<li>{{ HTML::link_to_action("maps@view", $map->title, array($map->id, $map->slug)) }}</li>
@endforeach
</ul>
@endsection