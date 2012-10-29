@layout("layout.main")

@section("content")
@include("user.menu")
<div id="content" class="messages view">
<div class="titlebar">
	<h2>Viewing: {{ e($thread->title) }}</h2>
	<div class="btn-group right">
		@if($thread->user_id)
			<a href="#" id="mess-ac-open" class="btn"><i class="icon-plus"></i> Details</a>
			<a href="#reply" class="btn"><i class="icon-share-alt"></i> Reply</a>
		@endif
	</div>
</div>
@if($thread->user_id)
	<div id="mess-actions" class="clearfix" style="display:none">
		<div class="left halfwidth">
			<div class="titlebar"><h3>In this thread</h3></div>
			<ul class="itt">
				@foreach($thread->users as $user)
					<li><a href="{{ URL::to("user/{$user->username}") }}"><img src="{{ $user->avatar_url }}" alt="avatar"> {{$user->username}}</a></li>
				@endforeach
			</ul>
		</div>
		<div class="right halfwidth">
			<div class="titlebar"><h3>Add people to this conversation</h3></div>
			{{ Form::open("messages/add/{$thread->id}", "",array("class" => "xpadding")) }}
				{{ Form::token() }}
				{{ Form::field("text", "users", "", array(Input::old("users"), array('class' => 'input-large')), array('error' => $errors->first('users'), "help-inline" => "Seperate multiple usernames with a comma")) }}
				{{ Form::submit("Add people") }}
			{{ Form::close() }}
		</div>
	</div>
@endif
<div class="titlebar"><h3>Messages</h3></div>
	<ul>
	@foreach($messages as $message)
		<li class="message">
			@if($message->user_id)
			<div class="vcard">
			<a href="{{ URL::to("user/{$message->user->username}") }}"><img src="{{ $message->user->avatar_url }}" alt="avatar"> {{$message->user->username}}</a> @ {{ $message->created_at }}
			</div>
			@else
			<div class="vcard">
			<a href="#"><img src="{{ URL::to_asset("images/static/system.png") }}" width="15"> System</a> @ {{ $message->created_at }}
			</div>
			@endif
			<div class="body">
			{{ $message->message }}
			</div>
		</li>
	@endforeach
	</ul>
	@if($thread->user_id)
		<div id="reply" class="titlebar"><h3>Reply</h3></div>
		<div class="clearfix">
			<div class="left halfwidth">
			{{ Form::open("messages/reply/{$thread->id}") }}
				{{ Form::token() }}
				{{ Form::field("textarea", "message", "", array(Input::old("message"), array("id" => "mrk", "style" => "width:445px")), array('error' => $errors->first('message'))) }}
				{{ Form::actions(Form::submit("Reply", array("class" => "btn-primary")))}}
			{{ Form::close() }}
			</div>
			<div class="right halfwidth">
				<div class="titlebar"><h4>Preview</h4></div>
				<li class="message">
					<div class="vcard">
					<a href="{{ URL::to("user/{ Auth::user()->username }") }}"><img src="{{ Auth::user()->avatar_url }}" alt="avatar"> {{ Auth::user()->username }}</a>
					</div>
					<div class="body">
					<div id="preview"></div>
					</div>
				</li>
			</div>
		</div>
	@endif
</div>
@endsection