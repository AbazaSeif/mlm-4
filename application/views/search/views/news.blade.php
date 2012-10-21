<li>
<a href="{{ URL::to_action("news@view", array($item->id, $item->slug)) }}" title="">
		<div class="mv-details">
		<div class="mv-title"><h1>{{ $item->title }}</h1></div>
		<div class="mv-summary"><p>{{ nl2br(e($item->summary)) }}</p></div>
		<div class="mv-meta">
			<span>By: <b>{{ $item->user->username}}</b></span>
			<span>Posted: <b>{{ HTML::entities(date("F j, Y g:ia", strtotime($item->created_at))) }}</b></span>
			<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
			<span>Item Type: <b>{{ ucfirst(Str::singular($item->searchresulttype)) }}</b></span>
		</div>
		</div>
</a>
</li>