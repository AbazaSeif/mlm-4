@layout("layout.main")

@section("content")
@include("matches.menu")
<div id="content">
<div id="page" class="bigger">
<div id="multiview">
<ul class="{{ Cookie::get('multiview', 'grid') }}">
@foreach ($matchlist->results as $match)
	<li>
		<div class="mv-details">
			<h1>{{ HTML::link_to_action("matches@view", $match->id, array($match->id)) }}</h1>
			<p>Team Red VS. Team Blue</p>
		</div>
	</li>
@endforeach
</ul>
</div>
</div>

</div>
@endsection