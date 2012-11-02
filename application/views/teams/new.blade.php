@layout("layout.main")

@section("content")
@include("teams.menu")
<div id="content" class="edit clearfix">
	{{ Form::open("teams/new", "POST", array("class" => "form")) }}
		{{ Form::token() }}
		{{ Form::field("text", "name", "Team name", array(Input::old("name"), array('class' => 'title')), array("help" => "Your team's name should stand out and be as clever. Derrogatives, swear words, and other offensive words are forbidden.","error" => $errors->first("title"))) }}
		{{ Form::field("text", "tagline", "Team tagline", array(Input::old("tagline"), array('class' => 'subtitle')), array("alt" => "(56 Characters)","help" => "Tagline/Slogan of your team. Derrogatives, swear words, and other offensive words are forbidden.", 'error' => $errors->first('tagline'))) }}
		{{ Form::field("wysiwyg-user", "description", "Team description", array(Input::old("description"), array("rows" => "15", 'class' => 'input-xxlarge')), array("help" => "Tell us about your team. What makes it great? What have you accomplished?", "error" => $errors->first("description"))) }}		
		{{ Form::field("checkbox", "private", "Private Team", array(Input::old("private")), array("help" => "Makes team viewable only by members", "error" => $errors->first("private"))) }}
		{{ Form::actions(Form::submit("Submit", array("class" => "btn-primary"))) }}
	{{ Form::close() }}
</div>
@endsection