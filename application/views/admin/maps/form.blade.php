@layout("layout.admin")

@section("content")
@parent
<div id="content">
<div class="titlebar clearfix">
	<h2>Editing map <b>{{$map->title}}</b></h2>
</div>
{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
	{{ Form::token() }}
	<formset>
		{{ Form::field("text", "title", "Title", array(Input::old("title", $map->title), array('class' => 'input-large')), array('error' => $errors->first('title'))) }}
		{{ Form::field("textarea", "summary", "Summary", array(Input::old("summary", $map->summary), array("rows" => "15")), array("help-inline" => "Short description about your map. (255 characters max)", 'error' => $errors->first('summary'))) }}
		{{ Form::field("wysiwyg", "description", "Long Description", array(Input::old("description", $map->description), array('class' => 'input-xxlarge')), array('error' => $errors->first('description'))) }}
		{{ Form::field("select", "maptype", "Type", array(Config::get("maps.types"), Input::old("maptype", $map->maptype), array('class' => 'input')), array('error' => $errors->first('maptype'))) }}
		{{ Form::field("text", "version", "Version", array(Input::old("version", $map->version)), array("error" => $errors->first("error"))) }}
		{{ Form::field("text", "teamcount", "Team count", array(Input::old("teamcount", $map->teamcount)), array("error" => $errors->first("error"))) }}
		{{ Form::field("text", "teamsize", "Recomended team size", array(Input::old("teamsize", $map->teamsize)), array("error" => $errors->first("teamsize"))) }}
		
		{{ Form::actions(array( Form::submit("Save", array("class" => "btn btn-primary")) )) }}
	</formset>
{{ Form::close() }}
</div>
@endsection