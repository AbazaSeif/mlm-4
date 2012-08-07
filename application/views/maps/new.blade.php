@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content">
	{{ Form::open("maps/new", "POST", array("class" => "form-horizontal nobg")) }}
		{{ Form::token() }}
		{{ Form::field("text", "title", "Title", array(Input::old("title"), array('class' => 'input-large')), array('error' => $errors->first('title'))) }}
		{{ Form::field("textarea", "summary", "Summary", array(Input::old("summary"), array('class' => 'input-xxlarge')), array("help" => "Short description about your map. (255 characters max)", 'error' => $errors->first('summary'))) }}
		{{ Form::field("wysiwyg", "description", "Long Description", array(Input::old("description"), array('class' => 'input-xxlarge')), array('error' => $errors->first('description'))) }}
		<div class="control-group">
			<div class="controls">
				<p class="help-block">After adding the map you can add download links and images by editing the map.</p>
			</div>
		</div>
		{{ Form::actions(Form::submit("Submit", array("class" => "btn-primary"))) }}
	{{ Form::close() }}
</div>
@endsection