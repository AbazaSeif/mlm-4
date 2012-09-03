@layout("layout.main")

@section("content")
@include("maps.menu")
{{ HTML::link_to_action("maps@view", "View", array($map->id, $map->slug)) }} 
{{ HTML::link_to_action("maps@edit", "Edit", array($map->id)) }}
<div id="content">
	@if($link->exists)
		<h2>Edit link</h3>
		{{ Form::open("maps/edit_link/".$map->id."/".$link->id, "POST", array("class" => "nobg")) }}
	@else
		<h3>New link</h3>
		{{ Form::open("maps/edit_link/".$map->id, "POST", array("class" => "nobg")) }}
	@endif
		{{ Form::token() }}
		{{ Form::field("text", "url", "URL", array(Input::old("url", $link->url), array('class' => 'input-large')), array('error' => $errors->first('url'))) }}
		{{ Form::field("select", "type", "Filetype", array(array("rar" => "rar", "zip" => "zip", "7z" => "7z"), Input::old("direct", $link->type), array("class" => "input-small")), array("error" => $errors->first("type"))) }}
		{{ Form::field("checkbox", "direct", "Direct download", array(1, Input::old("direct", $link->direct)), array("error" => $errors->first("direct"), "help-inline" => "Indicates that URL leads straight to download. This means no redirect pages, landing pages nor ads.")) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("maps@edit", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}

</div>
@endsection