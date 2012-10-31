@layout("layout.main")

@section("content")
<div id="content">
<div class="titlebar">
	<h2>Rejecting <strong>{{ e($user->username) }}</strong> from joining the team <strong>{{ e($team->name) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<div class="titlebar"><h4>Reason for rejecting application</h4></div>
	{{ Form::field("textarea", "reason", "", array(Input::old("reason"), array("rows" => "5", "class" => "input-xxlarge")), array('error' => $errors->first('reason'))) }}
	<p>Are you sure you would like to reject <i>{{ $user->username }}</i> from joining the team <i>{{ $team->name }}</i>?</p>
	{{ Form::submit("Reject from Team", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("teams.applications", "Back", array("id" => $team->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection