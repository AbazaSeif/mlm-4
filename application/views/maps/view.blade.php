@layout("layout.main")

@section("content")
<h2>{{ e($map->title) }}</h2>
<p>{{ e($map->summary) }}</p>
{{ $map->description }}

@foreach($authors as $author)
	{{-- These are all user objects, so feel free to do whatever --}}
	{{ HTML::link("user/".$author->username, $author->username) }}
@endforeach
@endsection