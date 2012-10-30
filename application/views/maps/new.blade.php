@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>New map</h2>
</div>
	<div id="page" class="maxwidth">
		{{ Form::open("maps/new", "POST", array("class" => "form")) }}
			<div class="alert alert-info">
				<h2>Heads up!</h2>
				<p>Here's some things to keep in mind while submitting a map:</p>
				<ol>
					<li>Try to fill out as much as possible.</li>
					<li>We'll only approve maps that have a working version released. Don't submit something you're working on.</li>
					<li>If you did not make the map, do not submit it. Tell the map maker that you would like to see his/her map on the site.</li>
					<li>Don't submit it more than once. You can check your maps even before they're approved on {{ HTML::link("maps/filter/?ownmaps=1", "your maps") }}.</li>
				</ol>
			</div>
			{{ Form::token()}}
			{{ Form::field("text", "title", "Map name", array( Input::old("title"), array('class' => 'title', 'autocomplete' => 'off') ),  array( 'error' => $errors->first('title'), "help" => "Title should only have the map's name") ) }}
			{{ Form::field("textarea", "summary", "Summary", array(Input::old("summary"), array("rows" => "15", 'class' => 'summary')), array('error' => $errors->first('summary'), "alt" => "(Explain your map 140 characters. Use correct grammar)")) }}
			{{ Form::field("wysiwyg-user", "description", "Description", array(Input::old("description"), array('class' => 'input-xxlarge')), array('error' => $errors->first('description'), "alt" => "(Use correct grammar)")) }}
			{{ Form::field("select", "maptype", "Map type", array(array_merge(array("" => "--------------"), Config::get("maps.types")), Input::old("maptype"), array('class' => 'input')), array('error' => $errors->first('maptype'))) }}
			{{ Form::field("text", "version", "Map version", array(Input::old("version")), array("error" => $errors->first("version"), "help" => "Map version is the version of the map, not the version of the game. Remember to keep this up-to-date!")) }}
			{{ Form::field("text", "mcversion", "Minecraft version", array(Input::old("mcversion")), array("error" => $errors->first("mcversion"), "help" => "The Minecraft Version for the map should be the latest version of Minecraft that the map was tested on and fully worked.")) }}
			{{ Form::field("text", "teamcount", "Teams", array(Input::old("teamcount")), array("error" => $errors->first("teamcount"), "help" => "How many teams can play the map at once")) }}
			{{ Form::field("text", "teamsize", "Team Size", array(Input::old("teamsize")), array("error" => $errors->first("teamsize"), "alt" => "(Players per team)")) }}
			<div class="control-group">
				<div class="controls">
					<p class="help-inline">After submitting the map you will be able to add download links and images by clicking on "Edit map" in the Actions bar above your map's page.</p>
				</div>
			</div>
			{{ Form::actions(array(Form::submit("Submit", array("class" => "btn-primary")), " ", HTML::link_to_action("maps@index", "Cancel", array(), array("class" => "btn")))) }}
		{{ Form::close() }}
	</div>
</div>
@endsection