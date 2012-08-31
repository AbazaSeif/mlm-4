@layout("layout.admin")

@section("content")
@parent
<div id="content">
<div class="titlebar clearfix">
	<h2>Creating FAQ Question</h2>
</div>
{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
	{{ Form::token() }}
	<formset>
		{{ Form::field("text", "question", "Question", array(Input::old("question"), array('class' => 'input-large')), array('error' => $errors->first('question'))) }}
		{{ Form::field("textarea", "answer", "Answer", array(Input::old("answer"), array('class' => 'input-large')), array('error' => $errors->first('answer'))) }}
		
		{{ Form::actions(array( Form::submit("Create", array("class" => "btn btn-primary")) )) }}
	</formset>
{{ Form::close() }}
</div>
@endsection