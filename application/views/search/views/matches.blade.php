<li>
<a href="{{ URL::to_action("matches@view", array($item->id)) }}" title="">
		<div class="mv-details">
		<div class="mv-title"><h1>{{ e($item->mapname) }} &nbsp - &nbsp {{ array_get(Config::get("maps.types"), $item->gametype) }}</h1></div>
		<div class="mv-summary"><p>{{ $item->info }}</p></div>
		<div class="mv-meta">
			<span>Players: <b>888</b></span>
			<span>Team Count: <b>{{ $item->team_count }}</b></span>
			<span>Status: <b>{{ $item->status }}</b>,</span>
			<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
			<span>Item Type: <b>{{ ucfirst(Str::singular(get_class($item))) }}</b></span>
		</div>
		</div>
</a>
</li>