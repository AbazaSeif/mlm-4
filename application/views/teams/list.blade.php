@layout("layout.main")

@section("content")
<div id="content">
<div id="titlebar"></div>
<div id="multiview">
<ul class="list">
@foreach ($teams->results as $team)
	<li>
	<a href="{{ URL::to_action("teams@view", array($team->id)) }}" title="View team">
		<div class="mv-details">
		<div class="mv-title"><h1>{{ $team->name }}</div>
		<div class="mv-summary"><p>{{ $team->summary }}</div>
		<div class="mv-meta">
			<span>Members: <b>{{ count($team->users) }}</span>
		</div>
		</div>
	</a>
	</li>
@endforeach
</ul>
</div>
</div>
@endsection