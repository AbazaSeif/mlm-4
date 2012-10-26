@layout("layout.main")

@section("content")
@include("matches.menu")
<div id="content">
<div id="titlebar"></div>
<div id="multiview">
<ul class="list">
@foreach ($matchlist->results as $match)
	<li>
	<a href="{{ URL::to_action("matches@view", array($match->id)) }}" title="">
		<div class="mv-details">
		<div class="mv-title"><p>Team Red VS. Team Blue</p></div>
		<div class="mv-meta">
			<span>Map: <b>{{$match->mapname}}</b></span>
		</div>
		</div>
	</a>
	</li>
@endforeach
</ul>
</div>
</div>
@endsection