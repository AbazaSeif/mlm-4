@layout("layout.main")

@section("content")
<div id="content">
	{{ Form::open("messages/new") }}
		{{ Form::token() }}
		{{ Form::field("text", "title", "Title", array(Input::old("title"), array('class' => 'input-large')), array('error' => $errors->first('title'))) }}
		{{ Form::field("text", "users", "Send to", array(Input::old("users"), array('class' => 'input-large')), array('error' => $errors->first('users'), "help" => "Seperate multiple usernames with a comma")) }}
		{{ Form::field("textarea", "message", "Message", array(Input::old("message"), array('class' => 'input-xxlarge')), array('error' => $errors->first('message'), "help" => "Markdown supported")) }}
		{{ Form::actions(array( Form::submit("Send", array("class" => "btn-primary")), " ", HTML::link("messages", "Back", array("class" => "btn")) )) }}
	{{ Form::close() }}
</div>


@endsection