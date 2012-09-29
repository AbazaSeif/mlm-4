@layout("layout.main")

@section("content")
@include("matches.menu")
<div id="content">
	{{ Form::open("matches/new", "POST", array("class" => "form-horizontal ")) }}
		{{ Form::token() }}
		{{ Form::field("text", "teamcount", "Team count", array(Input::old("teamcount")), array("error" => $errors->first("error"))) }}
		{{ Form::checkbox("adduser", "Join Match?", true) }}
		{{ Form::actions(Form::submit("Submit", array("class" => "btn-primary"))) }}
	{{ Form::close() }}
</div>
@endsection