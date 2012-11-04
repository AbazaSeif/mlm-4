@layout("layout.main")

@section("content")
<div id="content" class="edit clearfix">
	{{ Form::open("groups/new", "POST", array("class" => "form")) }}
		{{ Form::token() }}
		{{ Form::field("text", "name", "Group name", array(Input::old("name"), array('class' => 'title')), array("help" => "Your group's name should stand out and be descriptive of what it is. Derrogatives, swear words, and other offensive words are forbidden.","error" => $errors->first("name"))) }}
		{{ Form::field("text", "description", "Group description", array(Input::old("description"), array('class' => 'subtitle')), array("alt" => "(160 Characters)","help" => "Description of your group. Derrogatives, swear words, and other offensive words are forbidden.", 'error' => $errors->first('description'))) }}
		{{ Form::field("checkbox", "private", "Private Team", array(Input::old("private")), array("help" => "Makes team only joinable through an invitation", "error" => $errors->first("private"))) }}
		{{ Form::actions(Form::submit("Submit", array("class" => "btn-primary"))) }}
	{{ Form::close() }}
</div>
@endsection