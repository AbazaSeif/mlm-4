@layout("layout.main")
<?php $maptypes = Config::get("maps.types") ?>

@section("content")
@if($map->published == 0)
	<div class="alert">
		<p>This map is awaiting moderation and is not yet viewable by everyone.</p>
		@if(Auth::check() && Auth::user()->admin)
			<p>{{ HTML::link_to_action("admin.maps@view", "Moderate", array($map->id), array("class" => "btn")) }}</p>
		@endif
	</div>
@endif
@include("maps.menu")
<div id="content" class="maps-single clearfix">
<div class="titlebar">
	<h2>{{ e($map->title) }}</h2>
	<div class="rating-avg" title="{{ round($map->avg_rating, 1) }}/5"><i class="icon-star"></i><span class="number">{{ round($map->avg_rating, 1) }}</span></div>
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
		<div id="maps-slider" class="nivoSlider">
			@forelse($map->images as $image)
			<a href="{{ e($image->file_original) }}">
			<img src="{{ e($image->file_medium) }}" data-thumb="{{ e($image->file_medium) }}" alt="{{ e($map->title) }} image" />
			</a>
			@empty
			<img src="{{ URL::to_asset("images/static/noimage.jpg") }}" data-thumb="{{ URL::to_asset("images/static/noimage.jpg") }}" alt="No Images Found" />
			@endforelse
		</div>
	</div>
@unless(Auth::guest() or $is_owner)
<div class="titlebar autosubmit" style="margin-top:10px;"><h3>Your rating</h3>
	{{ Form::open("maps/rate/".$map->id, 'POST', array("style" => "display:inline;")) }}
	<fieldset class="rating">
    	{{ Form::radio("rating", 5, $rating == 5, array("id" => "star5")) }}<label for="star5" title="Rocks!">5 stars</label>
    	{{ Form::radio("rating", 4, $rating == 4, array("id" => "star4")) }}<label for="star4" title="Pretty good">4 stars</label>
    	{{ Form::radio("rating", 3, $rating == 3, array("id" => "star3")) }}<label for="star3" title="Meh">3 stars</label>
    	{{ Form::radio("rating", 2, $rating == 2, array("id" => "star2")) }}<label for="star2" title="Kinda bad">2 stars</label>
    	{{ Form::radio("rating", 1, $rating == 1, array("id" => "star1")) }}<label for="star1" title="Sucks big time">1 star</label>
    </fieldset>
	{{ Form::token() }}
	{{ Form::close() }}
</div>
@endif
@include("maps.comments")
</div>
</div>
@include('maps.sidebar')
</div>
@endsection