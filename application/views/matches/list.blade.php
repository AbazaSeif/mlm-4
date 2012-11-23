@layout("layout.main")

@section("content")
@include("matches.menu")
<div id="content" class="clearfix">
<div class="titlebar"><h2>MATCHES</h2></div>
	<div id="matches">
		<ol>
		@foreach ($matchlist->results as $match)
		<li class="match">
			<a href="{{ URL::to_action("matches@view", array($match->id)) }}" title="">
				<div class="info clearfix">
					<div class="teaminfo team-a"><h1>Team Red</h1><p>player 1, player 2, player 3, player 4, player 5</p></div>
					<div class="teaminfo team-b"><h1>Team Blue</h1><p>player 1, player 2, player 3, player 4, player 5</p></div>
				<div class="data">
					<img src="http://flickholdr.com/80/80/city">
					<div class="score"><div class="wins">3</div><div class="loses">2</div></div> 
					<img src="http://flickholdr.com/80/80/leon">
				</div>
				</div>
				<div class="details clearfix">
					<div class="left">
						<span>Match <b>RMCT #3.2.1</b></span><span>Map <b>{{$match->mapname}}</b></span>
					</div>
					<div class="right">
						<span>Time <b>22:00 GMT</b></span><span>Streamed <b>Yes</b></span><span style="padding-right:1px">Status: <b class="status green">In progress</b></span>
					</div>
				</div>
			</a>
		</li>
		@endforeach
		</ol>
	</div>
</div>
@endsection
<?php /*
<div class="mv-details">
<div class="mv-title"><p>Team Red VS. Team Blue</p></div>
<div class="mv-meta">
<span>Map: <b>{{$match->mapname}}</b></span>
</div>
</div>
 */ ?>