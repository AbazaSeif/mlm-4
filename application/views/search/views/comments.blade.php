<li>
@if($item->news_id != null)
<a href="{{ URL::to_action("news@view", array($item->news->id, $item->news->slug)) }}" title="">
@else
<a href="{{ URL::to_action("maps@view", array($item->map->id, $item->map->slug)) }}" title="">
@endif
		<div class="mv-details">
		<div class="mv-title"><h1>By {{ e($item->user->username) }}</h1></div>
		<div class="mv-summary">{{ $item->html }}</div>
		<div class="mv-meta">
			<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
			<span>Item Type: <b>{{ ucfirst(Str::singular($item->searchresulttype)) }}</b></span>
		</div>
		</div>
</a>
</li>