@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content">
	@if($version->exists)
	<div class="titlebar"><h2>Edit version</h2></div>
		{{ Form::open_for_files("maps/edit_version/".$map->id."/".$version->id, "POST", array("class" => "form-horizontal")) }}
	@else
	<div class="titlebar"><h2>Add version</h2></div>
		{{ Form::open_for_files("maps/edit_version/".$map->id, "POST", array("class" => "form-horizontal")) }}
	@endif
	@if(!$is_owner && Auth::user()->admin)
		<div class="alert">
			<h4>Not an owner</h4>
			<p>Using admin permissions to edit the map</p>
		</div>
	@endif
		{{ Form::token() }}
		{{ Form::field("text", "version", "Version", array(Input::old("version", $version->version)), array('error' => $errors->first('version'))) }}
		{{ Form::field("textarea", "changelog", "Changelog & release notes", array(Input::old("changelog", $version->changelog), array("class" => "input-xxlarge")), array('error' => $errors->first('changelog'))) }}
		{{ Form::field("file", "mapfile", "Map file (zip)", array(), array("help" => 'Check out <a href="http://majorleaguemining.net/mapmakerchecklist" target="_blank">The Mapmakers Checklist</a> for info on how to properly package your map.<br />Max file size 15MB. If your file is larger, contact us!'.($version->exists ? " If you'd like to keep the current file, don't uplaod anything." : ""), 'error' => $errors->first('mapfile'))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("maps@edit", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}

</div>
@endsection