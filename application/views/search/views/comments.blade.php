<li>
@if($item->news_id != null)
<a href="{{ URL::to_action("news@view", array($item->news->id, $item->news->slug)) }}" title="View comment">
@else
<a href="{{ URL::to_action("maps@view", array($item->map->id, $item->map->slug)) }}" title="View comment">
@endif
<div class="mv-details">
	<div class="mv-summary">{{ $item->html }}</div>
	<div class="mv-meta">
		<span>By <b>{{ e($item->user->username) }}</b></span>
		<span>commented on <b>
		@if($item->news_id != null)
		{{ Str::limit($item->news->title, 30) }}
		@elseif($item->map_id != null)
		{{ Str::limit($item->map->title, 30) }}
		@else
		<b>[Deleted]</b>
		@endif
		</b></span> on <span><b>{{ date("M j,Y g:ia", strtotime($item->created_at)) }}</b></span>
		<div class="right">
			<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
			<span>Item Type: <b>{{ ucfirst(Str::singular(get_class($item))) }}</b></span>
		</div>
</div>
</div>
</a>
</li>