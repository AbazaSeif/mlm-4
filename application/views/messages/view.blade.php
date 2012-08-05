@layout("layout.main")

@section("content")
<div id="content">
	<h3>{{ e($thread->title) }}</h3>
	<h4>In this thread:</h4>
	<ul>
		@foreach($thread->users as $user)
			<li><a href="{{ URL::to("user/".$user->username) }}"><img src="http://minotar.net/helm/{{ $user->mc_username }}/18.png" alt="avatar"> {{$user->username}}</a></li>
		@endforeach
	</ul>
	@foreach($thread->messages as $message)
	<small><a href="{{ URL::to("user/".$message->user->username) }}"><img src="http://minotar.net/helm/{{ $message->user->mc_username }}/12.png" alt="avatar"> {{$message->user->username}}</a> @ {{ $message->created_at }}</small>
	{{ $message->message }}
	@endforeach
	
</div>
@endsection