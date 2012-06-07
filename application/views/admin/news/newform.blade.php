@layout('layout.admin')

@section('content')
@parent
<div class="content">
{{ Form::open(null , 'POST', array('class' => 'form-horizontal')) }} 
	<fieldset>
		{{ Form::token() }}

		{{ Form::field("text", "title", "Title", array(Input::old("title"), array('class' => 'input-xxlarge')), array('error' => $errors->first('title'))) }}
		{{ Form::field("textarea", "summary", "Summary", array(Input::old("summary"), array("rows" => "4", 'class' => 'input-xxlarge')), array("error" => $errors->first("summary"))) }}
		{{ Form::field("imageselect", "image", "Header Image", array('class' => 'btn'), array(Input::old("image"), $oldimage), array("error" => $errors->first("image"))) }}
		{{ Form::field("textarea", "news_content", "Content", array(Input::old("news_content"), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("news_content"))) }}

		{{ Form::actions(array( Form::submit("Create", array("class" => "btn btn-primary")) )) }}
	</fieldset>
{{ Form::close() }}
</div>
@endsection