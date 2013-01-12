@layout("layout.main")

@section("content")
@include("teams.menu")
<div id="content">
<div class="titlebar"><h2>TEAMS</h2></div>
<div id="multiview">
<ul class="squared">
@foreach ($teams->results as $team)
	<li>
	<a href="{{ URL::to_action("teams@view", array($team->id)) }}" title="View team">
		<div class="mv-image">
			<img src="<?php /* URL::to_asset("images/static/blank.gif") */ ?>http://placekitten.com/176/176" data-original="" alt="{{ $team->name }}" />
		</div>
		<div class="mv-details">
		<div class="mv-title"><h1>{{ $team->name }}</div>
		</div>
	</a>
	</li>
@endforeach
</ul>
</div>
</div>
@endsection