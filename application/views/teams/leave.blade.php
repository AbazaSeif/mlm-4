@layout("layout.main")

@section("content")
<div id="content">
<div class="titlebar">
	<h2>Leaving Team <strong>{{ e($team->name) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you would like to leave the team <i>{{ $team->name }}</i>?</p>
	{{ Form::submit("Leave Team", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("teams.view", "Back", array("id" => $team->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection