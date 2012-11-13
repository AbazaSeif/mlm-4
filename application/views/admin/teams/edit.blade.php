@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit clearfix">
<div class="titlebar"><h2>Editing team <b>{{$team->name}}</b></h2></div>
<div id="page" class="maxwidth">
{{ Form::open(null, 'POST', array('class' => 'form')) }}
	{{ Form::token() }}
	{{ Form::field("text", "name", "Team Name", array(Input::old("name", $team->name), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('name'))) }}
	{{ Form::field("text", "tagline", "Team Tagline", array(Input::old("tagline", $team->tagline), array('class' => 'subtitle')), array("alt" => "(56 Characters)", "error" => $errors->first("tagline"))) }}
	{{ Form::field("wysiwyg", "description", "Team Bio", array(Input::old("description", $team->description), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("description"))) }}
	{{ Form::field("checkbox", "private", "Private Team", array(Input::old("private", !($team->public))), array("help" => "Makes team viewable by members only","error" => $errors->first("private"))) }}
	{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("admin@teams", "Cancel", array($team->id), array("class" => "btn")))) }}
{{ Form::close() }}
</div>
</div>
@endsection