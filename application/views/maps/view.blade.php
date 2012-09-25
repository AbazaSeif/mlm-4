@layout("layout.main")
<?php $maptypes = Config::get("maps.types") ?>

@section("content")
@if($map->published == 0)
	<div class="alert">
		<p>This map is awaiting moderation and is not yet viewable by everyone.</p>
	</div>
@endif
@include("maps.menu")

<ul class="submenu nav nav-pills">
@if(Auth::check() && Auth::user()->admin)
<li class="disabled"><a href="#">Actions:</a></li>
<li>
{{ HTML::link_to_action("admin@maps@view", "Moderate Map", array($map->id)) }}
</li>
@if($is_owner)
<li>
{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}
</li>
@endif
@elseif($is_owner)
<li class="disabled"><a href="#">Actions:</a></li>
<li>
{{ HTML::link_to_action("maps@edit", "Edit Map", array($map->id)) }}
</li>
@else
@endif
</ul>

<div id="content" class="maps-single clearfix">
<div class="titlebar clearfix">
	<h2>{{ e($map->title) }}</h2> 
</div>
	@if($is_owner === 0)
	<div class="alert">
		You have been invited to be an author of this map.
		{{ Form::open("maps/author_invite/".$map->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "accept") }}
			<button type="submit" class="btn btn-success btn-mini"><i class="icon-ok icon-white"></i> Accept</button>
		{{ Form::close() }}
		{{ Form::open("maps/author_invite/".$map->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "deny") }}
			<button type="submit" class="btn btn-danger btn-mini"><i class="icon-remove icon-white"></i> Deny</button>
		{{ Form::close() }}
	</div>
	@endif
<div id="page">
	<div class="slider-wrapper theme-medium">
		<div id="gslider" class="nivoSlider">
			@forelse($map->images as $image)
			<img src="{{ e($image->file_original) }}" data-thumb="{{ e($image->file_small) }}" alt="" />
			@empty
			<img src="{{ URL::to_asset("images/slides/5.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/5.jpg") }}" alt="" />
			@endforelse
		</div>
	</div>
</div>
<div id="sidebar">
<div class="titlebar clearfix">
	<h3>Map Details</h3>
</div>
	<div id="hidden">
	<p>{{ $map->description }}</p>
</div>

	@if($map->version)
	<span>
		Version: {{ e($map->version) }}
	</span>
	@endif
	@if($map->maptype)
	<span>
		Map type: {{ array_get($maptypes, $map->maptype) }}
	</span>
	@endif
	@if($map->teamcount)
	<span>
		Team count: {{ $map->teamcount }}
	</span>
	@endif
	@if($map->teamsize)
	<span>
		Team size: {{ $map->teamsize }}
	</span>
	@endif

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
	Rating: {{ $map->avg_rating }}/5
	@if(Auth::check() && !$is_owner)
	{{ Form::open("maps/rate/".$map->id) }}
		<label>{{ Form::radio("rating", 1, $rating == 1) }} 1</label>
		<label>{{ Form::radio("rating", 2, $rating == 2) }} 2</label>
		<label>{{ Form::radio("rating", 3, $rating == 3) }} 3</label>
		<label>{{ Form::radio("rating", 4, $rating == 4) }} 4</label>
		<label>{{ Form::radio("rating", 5, $rating == 5) }} 5</label>
		{{ Form::submit("Rate") }}
		{{ Form::token() }}
	{{ Form::close() }}
	@endunless
</div>
</div>
@endsection