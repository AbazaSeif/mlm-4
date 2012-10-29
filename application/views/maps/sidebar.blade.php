@if ($sidebar == "edit") 
<div id="sidebar" class="smaller">
	<div class="widget">
	<header><h1>Map Guidelines</h1></header>
	<div class="content">
	<ol>
		<li>Everything has to be filled, only completed maps will be approved</li>
		<li>If you did not make the map, do not submit it. Tell the map maker that you would like to see his/her map on the site.</li>
		<li>Submitting a map more than once could get you banned.</li>
		<li>Be clear in the title and description of your map.</li>
		<li>Title should only have the map's name</li>
		<li>Description should also explain features</li>
		<li>Derrogatory terms and swear words are not allowed under any circumstance.</li>
		<li>Map version is the version of the map, not the version of the game</li>
		<li>Maximum image dimensions is 1920x1080px and maximum size is 1000k(1mb). Minimum upload dimension is 446x240px. Images are scaled down/up to 1280x720p, 704x480p and 446x240p. Ideal image dimention is any image in the 16:9 format.</li>
		<li>The Minecraft Version for the map should be the latest version of Minecraft that the map was tested on and fully worked.</li>
	</ol>
	</div>
	</div>
</div>
@elseif ($sidebar == "view")
<div id="sidebar">
	<div class="titlebar">
		<h3>Map Details</h3>
	</div>

	<p>{{ $map->description }}</p>

	<div class="titlebar margin"><h4>Author/s</h4></div>

	<ul class="ulfix">
	@foreach($authors as $author)
		{{-- These are all user objects, so feel free to do whatever --}}
		<li class="xpadding"><img src="{{ $author->avatar_url }}" alt="avatar" /> {{ HTML::link("user/{$author->username}", $author->username) }}
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

	<div class="titlebar margin"><h4>Minecraft Version</h4></div>
	@if($map->mcversion)
	<span>{{ e($map->mcversion) }}</span>
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
@else
@endif