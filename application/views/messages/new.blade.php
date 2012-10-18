@layout("layout.main")

@section("content")
@include("user.menu")
<div id="content" class="edit clearfix">
<div id="page" class="maxwidth">
<div class="titlebar">
	<h2>New message</h2>
</div>
	{{ Form::open("messages/new", 'POST', array('class' => 'form')) }}
	{{ Form::token() }}
	<div class="titlebar"><h3>Title</h3></div>
	{{ Form::field("text", "title", "", array(Input::old("title"), array('class' => 'title')), array('error' => $errors->first('title'))) }}
	<div class="titlebar"><h3>Send to <small>(Separete multiple users with a comma)</small></h3></div>
		{{ Form::field("text", "users", "", array(Input::old("users"), array('class' => 'title')), array('error' => $errors->first('users'))) }}
	<div class="titlebar"><h3>Message</h3></div>
		{{ Form::field("textarea", "message", "", array(Input::old("message"), array("id" => "mrk", 'class' => 'summary')), array('error' => $errors->first('message'))) }}
		{{ Form::actions(array( Form::submit("Send", array("class" => "btn-primary")), " ", HTML::link("messages", "Back", array("class" => "btn")) )) }} 
	{{ Form::close() }}
</div>
</div>
@endsection