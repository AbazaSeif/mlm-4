@layout("layout.main")

@section("content")
<div id="content" class="edit clearfix">
	{{ Form::open("teams/new", "POST", array("class" => "form")) }}
		{{ Form::token() }}
		{{ Form::field("text", "name", "Team name", array(Input::old("name")), array("error" => $errors->first("error"))) }}
		{{ Form::field("text", "tagline", "Team tagline", array(Input::old("tagline"), array('class' => 'subtitle')), array('error' => $errors->first('tagline'))) }}
		{{ Form::field("wysiwyg", "description", "Team description", array(Input::old("description"), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("description"))) }}		
		{{ Form::field("checkbox", "private", "Private Team (not viewable by everyone)", array(Input::old("private")), array("error" => $errors->first("private"))) }}
		{{ Form::actions(Form::submit("Submit", array("class" => "btn-primary"))) }}
	{{ Form::close() }}
</div>
@endsection