@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content">
	{{ Form::open("maps/new", "POST", array("class" => "form-horizontal nobg")) }}
		{{ Form::token() }}
		{{ Form::field("text", "title", "Title", array(Input::old("title"), array('class' => 'input-large')), array('error' => $errors->first('title'))) }}
		{{ Form::field("textarea", "summary", "Summary", array(Input::old("summary"), array('class' => 'input-xxlarge')), array("help-inline" => "Short description about your map. (255 characters max)", 'error' => $errors->first('summary'))) }}
		{{ Form::field("wysiwyg", "description", "Long Description", array(Input::old("description"), array('class' => 'input-xxlarge')), array('error' => $errors->first('description'))) }}
		{{ Form::field("select", "maptype", "Type", array(Config::get("maps.types"), Input::old("maptype"), array('class' => 'input')), array('error' => $errors->first('maptype'))) }}
		{{ Form::field("text", "version", "Version", array(Input::old("version")), array("error" => $errors->first("error"))) }}
		{{ Form::field("text", "teamcount", "Team count", array(Input::old("teamcount")), array("error" => $errors->first("error"))) }}
		{{ Form::field("text", "teamsize", "Recomended team size", array(Input::old("teamsize")), array("error" => $errors->first("teamsize"))) }}
		<div class="control-group">
			<div class="controls">
				<p class="help-inline">After adding the map you can add download links and images by editing the map.</p>
			</div>
		</div>
		{{ Form::actions(Form::submit("Submit", array("class" => "btn-primary"))) }}
	{{ Form::close() }}
</div>
@endsection