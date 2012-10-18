@if(in_array($sidebar, array("edit", "new")))
<div id="sidebar" class="smaller">
	<div class="widget">
	<header><h1>Maps guidelines</h1></header>
	<div class="content">
	<p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>
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
		<li class="xpadding"><img src="http://minotar.net/helm/{{ $author->mc_username }}/32" alt="avatar" /> {{ HTML::link("user/{$author->username}", $author->username) }}
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