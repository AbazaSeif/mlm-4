@layout("layout.main")

@section("content")
<div id="content">
	{{ Form::open("maps/new", "POST", array("class" => "form-horizontal")) }}
		{{ Form::token() }}
		{{ Form::field("text", "title", "Title", array(Input::old("title"), array('class' => 'input-large')), array('error' => $errors->first('title'))) }}
		{{ Form::field("textarea", "summary", "Summary", array(Input::old("short"), array('class' => 'input-xxlarge')), array("help" => "Short description about your map. (255 characters max)", 'error' => $errors->first('summary'))) }}
		{{ Form::field("wysiwyg", "description", "Long Description", array(Input::old("description"), array('class' => 'input-xxlarge')), array('error' => $errors->first('description'))) }}
		{{ Form::actions(Form::submit("Submit", array("class" => "btn-primary"))) }}
	{{ Form::close() }}
</div>
@endsection