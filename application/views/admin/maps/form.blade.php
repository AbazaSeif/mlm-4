@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>Editing map <b>{{$map->title}}</b></h2>
</div>
<div id="page" class="maxwidth">
{{ Form::open(null, 'POST', array('class' => 'form')) }}
		{{ Form::token()}}
		{{ Form::field("text", "title", "", array(Input::old("title", $map->title), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('title'))) }}
		<div class="titlebar"><h4>Description</h4></div>
		{{ Form::field("wysiwyg", "description", "", array(Input::old("description", $map->description), array('class' => 'input-xxlarge')), array('error' => $errors->first('description'))) }}
		<div class="titlebar"><h4>Summary (Explain your map 140 characters. Use correct grammar)</h4></div>
		{{ Form::field("textarea", "summary", "", array(Input::old("summary", $map->summary), array("rows" => "15", 'class' => 'summary')), array('error' => $errors->first('summary'))) }}
		<div class="titlebar"><h4>Map type</h4></div>
		{{ Form::field("select", "maptype", "", array(array_merge(array("" => "--------------"), Config::get("maps.types")), Input::old("maptype", $map->maptype), array('class' => 'input')), array('error' => $errors->first('maptype'))) }}
		<div class="titlebar"><h4>Map version</h4></div>
		{{ Form::field("text", "version", "", array(Input::old("version", $map->version)), array("error" => $errors->first("error"))) }}
		<div class="titlebar"><h4>Minecraft version</h4></div>
		{{ Form::field("text", "mcversion", "", array(Input::old("mcversion", $map->mcversion)), array("error" => $errors->first("error"))) }}
		<div class="titlebar"><h4>Teams</h4></div>
		{{ Form::field("text", "teamcount", "", array(Input::old("teamcount", $map->teamcount)), array("error" => $errors->first("error"))) }}
		<div class="titlebar"><h4>Team Size</h4></div>
		{{ Form::field("text", "teamsize", "", array(Input::old("teamsize", $map->teamsize)), array("error" => $errors->first("teamsize"))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("admin@maps@view", "Cancel", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}
</div>
</div>
@endsection