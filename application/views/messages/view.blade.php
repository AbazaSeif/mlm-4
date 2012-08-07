@layout("layout.main")

@section("content")
@include("user.menu")
<div id="content">
	<h3>{{ e($thread->title) }}</h3>
	<h4>In this thread:</h4>
	<ul>
		@foreach($thread->users as $user)
			<li><a href="{{ URL::to("user/{$user->username}") }}"><img src="http://minotar.net/helm/{{ $user->mc_username }}/18.png" alt="avatar"> {{$user->username}}</a></li>
		@endforeach
	</ul>
	@foreach($thread->messages as $message)
	<small><a href="{{ URL::to("user/{$message->user->username}") }}"><img src="http://minotar.net/helm/{{ $message->user->mc_username }}/12.png" alt="avatar"> {{$message->user->username}}</a> @ {{ $message->created_at }}</small>
	{{ $message->message }}
	@endforeach
	<h4>Reply</h4>
	{{ Form::open("messages/reply/{$thread->id}") }}
		{{ Form::token() }}
		{{ Form::field("textarea", "message", "Message", array(Input::old("message"), array('class' => 'input-xxlarge')), array('error' => $errors->first('message'), "help" => "Markdown supported")) }}
		{{ Form::actions(Form::submit("Reply", array("class" => "btn-primary")))}}
	{{ Form::close() }}
</div>
@endsection