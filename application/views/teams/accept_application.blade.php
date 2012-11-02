@layout("layout.main")

@section("content")
@include("teams.menu")
<div id="content">
<div class="titlebar">
	<h2>Accepting <strong>{{ e($user->username) }}</strong> into the team <strong>{{ e($team->name) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you would like to allow <i>{{ $user->username }}</i> into the team <i>{{ $team->name }}</i>?</p>
	{{ Form::submit("Allow into Team", array("class" => "btn btn-success")) }}
	{{ HTML::link_to_action("teams.applications", "Back", array("id" => $team->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection