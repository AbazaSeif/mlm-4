@layout("layout.main")
<?php $maptypes = Config::get("maps.types") ?>

@section("content")
@if($map->published == 0)
	<div class="alert">
		<p>This map is awaiting moderation and is not yet viewable by everyone.</p>
	</div>
@endif
@include("maps.menu")
<div id="content" class="maps-single clearfix">
<div class="titlebar">
	<h2>{{ e($map->title) }}</h2>
	<span class="rating">
		<span class="star"></span>
		<span class="star"></span>
		<span class="star"></span>
		<span class="star"></span>
		<span class="star"></span>
	</span>
</div>
	@if($is_owner === 0)
	<div class="alert alert-info alert-block alertfix clearfix">
		<p>You have been invited to be an author of this map.</p>
		{{ Form::open("maps/author_invite/".$map->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "accept") }}
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Accept</button>
		{{ Form::close() }}
		{{ Form::open("maps/author_invite/".$map->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "deny") }}
			<button type="submit" class="btn btn-danger"><i class="icon-remove icon-white"></i> Deny</button>
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
	<div class="titlebar">
		<h3>Map Details</h3>
	</div>

	<p>{{ $map->description }}</p>

	<div class="titlebar margin"><h4>Author/s</h4></div>

	<ul class="ulfix">
	@foreach($authors as $author)
		{{-- These are all user objects, so feel free to do whatever --}}
		<li class="xpadding"><img src="http://minotar.net/helm/{{ $author->mc_username }}/32.png" alt="avatar" /> {{ HTML::link("user/{$author->username}", $author->username) }}
		</li>
	@endforeach
	</ul>

	<div class="titlebar margin"><h4>Map type</h4></div>
	@if($map->maptype)
	<span>{{ array_get($maptypes, $map->maptype) }}</span>
	@endif

	<div class="titlebar margin"><h4>Version</h4></div>
	@if($map->version)
	<span>{{ e($map->version) }}</span>
	@endif

	<div class="titlebar margin"><h4>Teams</h4></div>
	@if($map->teamcount)
	<span>{{ $map->teamcount }}</span>
	@endif

	<div class="titlebar margin"><h4>Suggested team size</h4></div>
	@if($map->teamsize)
	<span>{{ $map->teamsize }}</span>
	@endif

	<div class="titlebar margin"><h4>Downloads</h4></div>
	<?php $i = 1; ?>
	@foreach($map->links as $link)
 	<span class="inline">{{ HTML::link($link->url, "Link ".$i, array("class" => "btn btn-success", "target" => "_blank")) }}</span>
	<?php $i++; ?>
 @endforeach
<!-- {{--
	Rating: {{ $map->avg_rating }}/5
	@if(Auth::check())
	{{ Form::open("maps/rate/".$map->id, 'POST', array('class' => 'rating')) }}
		<label>{{ Form::radio("rating", 1, $rating == 1) }}</label>
		<label>{{ Form::radio("rating", 2, $rating == 2) }}</label>
		<label>{{ Form::radio("rating", 3, $rating == 3) }}</label>
		<label>{{ Form::radio("rating", 4, $rating == 4) }}</label>
		<label>{{ Form::radio("rating", 5, $rating == 5) }}</label>
		{{ Form::submit("Rate") }}
		{{ Form::token() }}
	{{ Form::close() }}
	@endif
--}} -->
</div>
</div>
@endsection