@if($item->published)
<li>
<a href="{{ URL::to_action("maps@view", array($item->id, $item->slug)) }}" title="View map">
		<div class="mv-image">
		@if($item->image)
		{{ HTML::image($item->image->file_medium) }}
		@else
		<img src="{{ URL::to_asset("images/static/noimage.jpg") }}" alt="No Images found" />
		@endif
		</div>
		<div class="mv-details">
		<div class="mv-title"><h1>{{ e($item->title) }}</h1></div>
		<div class="mv-summary"><p>{{ $item->summary }}</p></div>
		<div class="mv-meta">
			<span>By 
				@foreach($item->users as $author)
				<b>{{ $author->username }}</b>,
				@endforeach
			</span>
			<span>Version <b>{{$item->version}}</b>,</span>
			@unless($item->published)
			<p><strong>This map isn't yet published</strong></p>
			@endunless
			<span>Type: <b>{{ array_get(Config::get("maps.types"), $item->maptype) }}</b></span>
			<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
			<span>Item Type: <b>{{ ucfirst(Str::singular(get_class($item))) }}</b></span>
		</div>
		</div>
</a>
</li>
@endif