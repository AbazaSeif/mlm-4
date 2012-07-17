@layout("layout.main")

@section("content")
{{ HTML::link_to_action("maps@view", "View", array($map->id, $map->slug)) }}

<h2>Edit meta</h2>
{{ Form::open("maps/edit_meta/".$map->id, "POST", array("class" => "form-horizontal")) }}
	{{ Form::token() }}
	{{ Form::field("text", "title", "Title", array(Input::old("title", $map->title), array('class' => 'input-large')), array('error' => $errors->first('title'))) }}
	{{ Form::field("textarea", "summary", "Summary", array(Input::old("summary", $map->summary), array('class' => 'input-xxlarge')), array("help" => "Short description about your map. (255 characters max)", 'error' => $errors->first('summary'))) }}
	{{ Form::field("wysiwyg", "description", "Long Description", array(Input::old("description", $map->description), array('class' => 'input-xxlarge')), array('error' => $errors->first('description'))) }}
	{{ Form::actions(Form::submit("Submit", array("class" => "btn-primary"))) }}
{{ Form::close() }}
@endsection