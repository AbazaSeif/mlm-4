<li>
<a href="{{ URL::to_action("users@view", array($item->id)) }}" title="">
		<div class="mv-details">
		<div class="mv-title"><h1>{{ e($item->username) }}</h1></div>
		<div class="mv-meta">
			<span>Member Since: <b>{{ date("F j, Y", strtotime($item->created_at)) }}</b></span>
			<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
			<span>Item Type: <b>{{ ucfirst(Str::singular($item->searchresulttype)) }}</b></span>
		</div>
		</div>
</a>
</li>