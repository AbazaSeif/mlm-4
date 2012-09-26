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
@include("maps.comments")
</div>
</div>
@include('maps.sidebar')
@endsection