<li>
<a href="{{ URL::to_action("teams@view", array($item->id)) }}" title="View team">
		<div class="mv-details">
		<div class="mv-title"><h1>{{ e($item->name) }}</h1></div>
		<div class="mv-summary"><p>{{ $item->tagline }}</p></div>
		<div class="mv-meta">
			<span>Players: <b>{{ count($item->users) }}</b></span>
			<div class="right">
				<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
				<span>Item Type: <b>{{ ucfirst(Str::singular(get_class($item))) }}</b></span>
			</div>
		</div>
		</div>
</a>
</li>