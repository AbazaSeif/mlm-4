@layout("layout.main")

@section("content")
@include("teams.menu")
<div id="content">
<div class="titlebar">
	<h2>Kicking <strong>{{ e($user->username) }}</strong> from team <strong>{{ e($team->name) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you would like to kick <i>{{ $user->username }}</i> from the team <i>{{ $team->name }}</i>?</p>
	{{ Form::submit("Kick from Team", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("teams.edit", "Back", array("id" => $team->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection