@layout('layout.admin')

@section('content')
@parent
<div id="content">
<div class="titlebar clearfix">
	<h2>Editing page <b>{{$page->title}}</b></h2>
</div>
{{ Form::open(null , 'POST', array('class' => 'form-horizontal')) }} 
	<fieldset>
		{{ Form::token() }}

		{{ Form::field("text", "title", "Title", array(Input::old("title", $page->title), array('class' => 'input-xxlarge','autocomplete' => 'off')), array('error' => $errors->first('title'))) }}
		{{ Form::field("text", "slug", "Slug", array(Input::old("slug", $page->url_slug), array('class' => 'input-large')), array("error" => $errors->first("slug"))) }}
		{{ Form::field("wysiwyg", "data", "Data", array(Input::old("data", $page->data), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("data"))) }}		

		{{ Form::actions(array( Form::submit("Save", array("class" => "btn btn-primary")) )) }}
	</fieldset>
{{ Form::close() }}
</div>
@endsection