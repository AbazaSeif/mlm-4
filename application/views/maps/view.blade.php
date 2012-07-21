@layout("layout.main")

@section("content")
@if($is_owner)
{{ HTML::link_to_action("maps@edit", "Edit", array($map->id)) }}
@endif
<div id="content" class="maps">
	@unless($map->published)
	<div class="alert">
		<h4 class="alert-heading">This map is not yet viewable by everyone</h4>
	</div>
	@endunless
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
	<h3>Downloads</h3>
	<ul>
	@foreach($map->links as $link)
		<li>{{ HTML::image($link->favicon, "favicon")." ".HTML::link($link->url, $link->url) }}</li>
	@endforeach
	</ul>
	<h2>Images</h2>
	<ul class="thumbnails">
		@forelse($map->images as $image)
			<li class="span2">
				<a href="{{ e($image->file_original) }}" class="thumbnail">{{ HTML::image($image->file_small) }}</a>
			</li>
		@empty
			<li>
				No images found!
			</li>
		@endforelse
	</ul>
</div>
@endsection