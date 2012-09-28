@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>New page</h2>
</div>
{{ Form::open(null , 'POST', array('class' => 'form-horizontal')) }} 
	<fieldset>
		{{ Form::token() }}

		{{ Form::field("text", "title", "Title", array(Input::old("title"), array('class' => 'input-xxlarge','autocomplete' => 'off')), array('error' => $errors->first('title'))) }}
		{{ Form::field("text", "slug", "Slug", array(Input::old("slug"), array('class' => 'input-large')), array("error" => $errors->first("slug"))) }}
		{{ Form::field("wysiwyg", "data", "Data", array(Input::old("data"), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("data"))) }}		

		{{ Form::actions(array( Form::submit("Create", array("class" => "btn btn-primary")) )) }}
	</fieldset>
{{ Form::close() }}
</div>
@endsection