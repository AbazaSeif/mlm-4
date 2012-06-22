@layout("layout.main")

@section("content")
{{ HTML::link_to_action("maps@new", "New map") }}

@foreach ($maps->results as $map)
	{{ HTML::link_to_action("maps@view", $map->title, array($map->id, $map->slug)) }}
@endforeach

@endsection