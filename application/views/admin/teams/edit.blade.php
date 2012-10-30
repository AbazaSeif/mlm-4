@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>Editing team <b>{{$team->name}}</b></h2>
</div>
<div id="page" class="maxwidth">
{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
		{{ Form::token() }}
		<div class="titlebar"><h4>Team Name</h4></div>
		{{ Form::field("text", "name", "", array(Input::old("name", $team->name), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('name'))) }}
		<div class="titlebar"><h4>Team Long bio</h4></div>
		{{ Form::field("wysiwyg-user", "description", " ", array(Input::old("description", $team->description), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("description"))) }}
		<div class="titlebar"><h4>Short bio <small>(140 characters)</small></h4></div>
		{{ Form::field("textarea", "summary", "", array(Input::old("summary", $team->summary), array("rows" => "15", 'class' => 'summary')), array('error' => $errors->first('summary'))) }}
		<div class="titlebar"><h4>Private Team <small>(Viewable only by members)</small></h4></div>
		{{ Form::field("checkbox", "private", "", array(Input::old("private", !($team->public))), array("error" => $errors->first("private"))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("admin@teams", "Cancel", array($team->id), array("class" => "btn")))) }}
	{{ Form::close() }}
</div>
</div>
@endsection