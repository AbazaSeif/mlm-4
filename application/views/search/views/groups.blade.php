<li>
	<div class="mv-details">
	<div class="mv-title"><h1>{{ e($item->name) }}</h1></div>
	<div class="mv-summary"><p>{{ $item->description }}</p></div>
	<div class="mv-meta">
		<span>Members: <b>{{ count($item->users) }}</b></span>
		<div class="right">
			<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
			<span>Item Type: <b>{{ ucfirst(Str::singular(get_class($item))) }}</b></span>
		</div>
	</div>
	</div>
</li>