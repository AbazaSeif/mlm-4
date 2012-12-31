@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content">
	@if($link->exists)
	<div class="titlebar"><h2>Edit Link</h2></div>
		{{ Form::open("maps/edit_link/".$map->id."/".$link->id, "POST", array("class" => "form-horizontal")) }}
	@else
	<div class="titlebar"><h2>Add link</h2></div>
		{{ Form::open("maps/edit_link/".$map->id, "POST", array("class" => "form-horizontal")) }}
	@endif
	@if(!$is_owner && Auth::user()->admin)
		<div class="alert">
			<h4>Not an owner</h4>
			<p>Using admin permissions to edit the map</p>
		</div>
	@endif
		{{ Form::token() }}
		{{ Form::field("text", "title", "Title", array(Input::old("title", $link->title), array("class" => "input-large")), array("error" => $errors->first("title"))) }}
		{{ Form::field("text", "url", "URL", array(Input::old("url", $link->url), array('class' => 'input-large')), array('error' => $errors->first('url'))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("maps@edit", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}

</div>
@endsection