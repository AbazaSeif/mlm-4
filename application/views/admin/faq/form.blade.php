@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit">
<div class="titlebar"><h2>Editing FAQ question: <b>{{$faq->title}}</b></h2></div>
{{ Form::open(null, 'POST', array('class' => 'form')) }}
	{{ Form::token()}}
	{{ Form::field("text", "question", "", array(Input::old("question",$faq->question), array('class' => 'title', 'autocomplete' => 'off', 'placeholder' => 'Question')), array('error' => $errors->first('question'))) }}
	{{ Form::field("wysiwyg", "answer", "Answer", array(Input::old("answer",$faq->answer), array('class' => 'input-xxlarge')), array('error' => $errors->first('answer'))) }}
	{{ Form::actions(array(Form::submit("Save", array("class" => "btn btn-primary"))," ",HTML::link_to_action("admin@faq", "Cancel",array(), array("class" => "btn") ))) }}
{{ Form::close() }}
</div>
@endsection