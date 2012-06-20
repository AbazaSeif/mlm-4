@layout("layout.admin")

@section("content")
@parent
<div id="content">
<div class="titlebar clearfix">
	<h2>Editing article <b>{{$newsitem->title}}</b></h2>
</div>
{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }} 
	<fieldset>
		{{ Form::token() }}

		{{ Form::field("text", "title", "Title", array(Input::old("title", $newsitem->title), array('class' => 'input-xxlarge','autocomplete' => 'off')), array('error' => $errors->first('title'))) }}
		{{ Form::field("textarea", "summary", "Summary", array(Input::old("summary", $newsitem->summary), array("rows" => "4", 'class' => 'input-xxlarge')), array("error" => $errors->first("summary"))) }}
		{{ Form::field("imageselect", "image", "Header Image", array(Input::old("image", $newsitem->image_id), $previewimage), array("error" => $errors->first("image"))) }}
		{{ Form::field("wysiwyg", "news_content", "Content", array(Input::old("news_content", $newsitem->content), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("news_content"))) }}
		{{ Form::field("checkbox", "published", "Published", array(1, Input::old("published", $newsitem->published)), array("error" => $errors->first("published"))) }}

		{{ Form::actions(array( Form::submit("Save", array("class" => "btn btn-primary")) )) }}
	</fieldset>
{{ Form::close() }}
</div>

@endsection