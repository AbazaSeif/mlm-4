@layout("layout.main")

@section("content")
@include("matches.menu")
<div id="content">
<div class="titlebar">
	<h2>Joining Match <strong>{{ e($match->id) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Which team won?</p>
	<div id="multiview">
	<ul class="{{ Cookie::get('multiview', 'grid') }}">
		@for ($i = 1; $i <= $match->team_count; $i++)
		<div id="mv-details">
			@foreach($match->users as $user)
			@if($user->pivot->teamnumber == $i)
				<p>{{ $user->username }}</p>
			@endif
			@endforeach
			{{ Form::submit("Set Winning Team ".$i, array("class" => "btn btn-warning", "name" => "teamnumber", "value" => $i)) }}
		</div>
		@endfor
	</ul>
	</div>
	{{ HTML::link_to_action("match.view", "Back", array("id" => $match->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection