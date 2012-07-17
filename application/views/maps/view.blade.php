@layout("layout.main")

@section("content")
@if($is_owner)
{{ HTML::link_to_action("maps@edit", "Edit", array($map->id)) }}
@endif
<h2>{{ e($map->title) }}</h2>
<p>{{ e($map->summary) }}</p>
{{ $map->description }}
<h3>Authors</h3>
<ul>
@foreach($authors as $author)
	{{-- These are all user objects, so feel free to do whatever --}}
	<li>{{ HTML::link("user/{$author->username}", $author->username) }}</li>
@endforeach
</ul>
@endsection