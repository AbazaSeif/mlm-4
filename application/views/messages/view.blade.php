@layout("layout.main")

@section("content")
@include("user.menu")
<div id="content">
	<h3>{{ e($thread->title) }}</h3>
	<h4>In this thread:</h4>
	<ul>
		@foreach($thread->users as $user)
			<li><a href="{{ URL::to("user/{$user->username}") }}"><img src="http://minotar.net/helm/{{ $user->mc_username }}/18" alt="avatar"> {{$user->username}}</a></li>
		@endforeach
	</ul>
	<h5>Add:</h5>
	{{ Form::open("messages/add/{$thread->id}") }}
		{{ Form::token() }}
		{{ Form::field("text", "users", "Usernames", array(Input::old("users"), array('class' => 'input-large')), array('error' => $errors->first('users'), "help-inline" => "Seperate multiple usernames with a comma")) }}
		{{ Form::submit("Add people") }}
	{{ Form::close() }}
	@foreach($messages as $message)
		<div class="message">
			@if($message->user_id)
			<small><a href="{{ URL::to("user/{$message->user->username}") }}"><img src="http://minotar.net/helm/{{ $message->user->mc_username }}/12" alt="avatar"> {{$message->user->username}}</a> @ {{ $message->created_at }}</small>
			@else
			<small>System @ {{ $message->created_at }}</small>
			@endif
			{{ $message->message }}
		</div>
	@endforeach
	{{-- Only if the thread wasn't started by the system --}}
	@if($thread->userid)
	<h4>Reply</h4>
	{{ Form::open("messages/reply/{$thread->id}") }}
		{{ Form::token() }}
		{{ Form::field("textarea", "message", "Message", array(Input::old("message"), array('class' => 'input-xxlarge')), array('error' => $errors->first('message'), "help-inline" => "Markdown supported")) }}
		{{ Form::actions(Form::submit("Reply", array("class" => "btn-primary")))}}
	{{ Form::close() }}
	@endif
</div>
@endsection