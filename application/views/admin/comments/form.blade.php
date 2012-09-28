@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Editing Comment <b>{{ $comment->id }}</b> by <b>{{ $comment->user->username }}</b></h2>
</div>
{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
	{{ Form::token() }}
	<formset>
		{{ Form::field("textarea", "source", "Comment", array(Input::old("source", $comment->source), array('class' => 'input-large')), array('error' => $errors->first('source'))) }}
		{{ Form::actions(array( Form::submit("Save", array("class" => "btn btn-primary")) )) }}
	</formset>
{{ Form::close() }}
</div>
@endsection