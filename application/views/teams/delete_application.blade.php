@layout("layout.main")

@section("content")
<div id="content">
<div class="titlebar">
	<h2>Deleting application by <strong>{{ e($user->username) }}</strong> for joining the team <strong>{{ e($team->name) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you want to delete <i>{{ $user->username }}</i>'s application for joining the team <i>{{ $team->name }}</i>? <br/>(This will allow them to re-apply if they were previously rejected from joining the team)</p>
	{{ Form::submit("Delete application", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("teams.applications", "Back", array("id" => $team->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection