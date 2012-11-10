@layout("layout.main")

@section("content")
@include("user.menu")
<div id="content" class="edit messages clearfix">
<div id="page" class="maxwidth">
<div class="titlebar">
	<h2>New message</h2>
</div>
<div class="clearfix">
	<div class="left halfwidth">
	{{ Form::open("messages/new", 'POST', array('class' => 'form')) }}
	{{ Form::token() }}
	<div class="titlebar"><h3>Subject</h3></div>
	{{ Form::field("text", "title", "", array(Input::old("title"), array('class' => 'title')), array('error' => $errors->first('title'))) }}
	<div class="titlebar"><h3>Send to <small>(Seperate multiple users with a comma)</small></h3></div>
		{{ Form::field("text", "users", "", array(Input::old("users", $name), array('class' => 'title')), array('error' => $errors->first('users'))) }}
	<div class="titlebar"><h3>Message</h3></div>
		{{ Form::field("textarea", "message", "", array(Input::old("message"), array("id" => "mrk", 'class' => 'summary')), array('error' => $errors->first('message'))) }}
		{{ Form::actions(array( Form::submit("Send", array("class" => "btn-primary")), " ", HTML::link("messages", "Back", array("class" => "btn")) )) }} 
	{{ Form::close() }}
	</div>
<div class="right halfwidth">
		<div class="titlebar"><h4>Preview</h4></div>
		<li class="message">
			<div class="vcard">
				<a href="{{ URL::to("user/".Auth::user()->username) }}"><img src="{{ Auth::user()->avatar_url }}" alt="avatar" width="15">{{ Auth::user()->username }}</a>
			</div>
			<div class="body">
			<div id="preview"></div>
			</div>
		</li>
	</div>
</div>
</div>
@endsection