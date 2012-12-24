@if ($sidebar == "view")
<div id="sidebar">
	<div class="titlebar">
		<h3>Map Details</h3>
	</div>

	<p>{{ $map->description }}</p>

	<div class="titlebar margin"><h4>Author/s</h4></div>

	<ul class="ulfix">
	@foreach($authors as $author)
		{{-- These are all user objects, so feel free to do whatever --}}
		<li class="xpadding"><img src="{{ $author->avatar_url }}" alt="avatar" /> {{ HTML::link("user/{$author->username}", $author->username) }}</li>
	@endforeach
	</ul>

	<div class="titlebar margin"><h4>Map type</h4></div>
	@if($map->maptype)
	<span>{{ array_get($maptypes, $map->maptype) }}</span>
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

	@if($version && $version->uploaded)
		<div class="big-green-download-box">
			<a href="{{ "/maps/get/".$map->id."/".$version->id }}" class="download-capture clearfix">
				<div class="clearfix">
					<i class="icon-arrow-down arrow-pointing-down"></i>
					<div class="big-downlaod-text">Download Now</div>
					<div class="muted">.zip - wget friendly :)</div>
				</div>
				@if($version->autoref)
				<span class="label label-success"><i class="icon-ok"></i> autoreferee.yml</span>
				@endif
			</a>
			<?php /* In the future when this can be done
			<div class="otherway">
				Or load it on your autoreferee server:
				<input type="text" value="{{ "/autoref load whatever-it-will-be-in-the-future" }}" class="transparent" />
			</div>
			*/ ?>
		</div>
	@endif


	<div class="titlebar margin"><h4>Links</h4></div>
	<?php $i = 1; ?>
	@foreach($map->links as $link)
 	<span class="inline">{{ HTML::link($link->url, "Link ".$i, array("class" => "btn btn-success", "target" => "_blank")) }}</span>
	<?php $i++; ?>
 	@endforeach
</div>
@else
@endif