@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>New map</h2>
</div>
	<div id="page" class="bigger">
		{{ Form::open("maps/new", "POST", array("class" => "form")) }}
		{{ Form::token()}}
		<div class="titlebar"><h4>Map name</h4></div>
		{{ Form::field("text", "title", "", array(Input::old("title"), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('title'))) }}
		<div class="titlebar"><h4>description (Use correct grammar)</h4></div>
		{{ Form::field("wysiwyg-user", "description", "", array(Input::old("description"), array('class' => 'input-xxlarge')), array('error' => $errors->first('description'))) }}
		<div class="titlebar"><h4>Summary (Explain your map 140 characters. Use correct grammar)</h4></div>
		{{ Form::field("textarea", "summary", "", array(Input::old("summary"), array("rows" => "15", 'class' => 'summary')), array('error' => $errors->first('summary'))) }}
		<div class="titlebar"><h4>Map type</h4></div>
		{{ Form::field("select", "maptype", "", array(array_merge(array("" => "--------------"), Config::get("maps.types")), Input::old("maptype"), array('class' => 'input')), array('error' => $errors->first('maptype'))) }}
		<div class="titlebar"><h4>Map version (Remember to keep this up-to-date!)</h4></div>
		{{ Form::field("text", "version", "", array(Input::old("version")), array("error" => $errors->first("error"))) }}
		<div class="titlebar"><h4>Teams (How many teams can play the map at once)</h4></div>
		{{ Form::field("text", "teamcount", "", array(Input::old("teamcount")), array("error" => $errors->first("error"))) }}
		<div class="titlebar"><h4>Team Size (Players per team)</h4></div>
		{{ Form::field("text", "teamsize", "", array(Input::old("teamsize")), array("error" => $errors->first("teamsize"))) }}
		<div class="control-group">
			<div class="controls">
				<p class="help-inline">After submitting the map you will be able to add download links and images by clickin on "Edit map" in the Actions bar above your map's page.</p>
			</div>
		</div>
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("maps@view", "Cancel", array(), array("class" => "btn")))) }}
	{{ Form::close() }}
	</div>
</div>
@endsection