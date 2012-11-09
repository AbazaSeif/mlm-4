@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>Editing Group <b>{{$group->name}}</b></h2>
</div>
<div id="page" class="maxwidth">
{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
		{{ Form::token() }}
		<div class="titlebar"><h4>Group Name</h4></div>
		{{ Form::field("text", "name", "", array(Input::old("name", $group->name), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('name'))) }}
		<div class="titlebar"><h4>Group description <small>(160 character limit)</small></h4></div>
		{{ Form::field("text", "description", " ", array(Input::old("description", $group->description), array("rows" => "3", 'class' => 'input-xxlarge')), array("error" => $errors->first("description"))) }}
		<div class="titlebar"><h4>Closed Team <small>(Only joinable by request)</small></h4></div>
		{{ Form::field("checkbox", "private", "", array(Input::old("private", !($group->open))), array("error" => $errors->first("private"))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("admin@groups", "Cancel", array(), array("class" => "btn")))) }}
	{{ Form::close() }}
</div>
</div>
@endsection