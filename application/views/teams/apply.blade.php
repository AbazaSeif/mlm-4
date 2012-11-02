@layout("layout.main")

@section("content")
@include("teams.menu")
<div id="content">
<div class="titlebar">
	<h2>Applying to join team <strong>{{ e($team->name) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<div class="alert alert-info">
		{{ nl2br(e($team->applications_text)) }}
	</div>
	{{ Form::field("textarea", "text", "", array(Input::old("text"), array("rows" => "10", "class" => "input-xxlarge")), array('error' => $errors->first('text'))) }}
	<p>Are you sure you would like to apply to join the team <i>{{ $team->name }}</i>?</p>
	{{ Form::submit("Apply to join Team", array("class" => "btn btn-success")) }}
	{{ HTML::link_to_action("teams.view", "Back", array("id" => $team->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection