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

	<div class="titlebar margin"><h4>Single/Multi-player</h4></div>
	@if($map->teamcount != 1 && $map->teamsize !=1)
		<span>Multiplayer</span>
		<div class="titlebar margin"><h4>Teams</h4></div>
	@if($map->teamcount)
		<span>{{ $map->teamcount }}</span>
	@endif

	<div class="titlebar margin"><h4>Suggested team size</h4></div>
	@if($map->teamsize)
		<span>{{ $map->teamsize }}</span>
	@endif
	@else
		<span>Singleplayer</span>
	@endif

	<div class="titlebar margin"><h4>Number of Downloads</h4></div>
	<span>{{ $map->hit_count }}</span>


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
	@foreach($map->links as $link)
 		<span>{{ HTML::image($link->favicon, "favicon", array("width" => "12"))." ".HTML::link($link->url, $link->title, array("target" => "_blank")) }}</span>
 	@endforeach
 	<br/>
 	<span><a href="#" rel="popover" data-html="true"
			data-content='
			{{ Form::open("maps/reportmap", "POST", array("class" => "center")) }}
			{{ Form::token() }}
			{{ Form::hidden("id", $map->id) }}
			{{ Form::field("select", "type", "Reason for Reporting", array(Config::get("admin.report-types"))) }}
			{{ Form::field("textarea", "details", "Additional Details", array(Input::old("summary"), array("rows" => "5"))) }}
			{{ Form::submit("Submit Report", array("class" => "btn-danger")) }}
			{{ Form::close() }}
			' data-original-title='Report Map'><button class="btn btn-danger">Report Map</button></a></span>
</div>
@else
@endif