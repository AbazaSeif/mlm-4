@layout("layout.main")

@section("content")
@include("user.menu")
<div id="content" class="messages clearfix">
<div id="page" class="maxwidth">
<div class="titlebar"><h2>Messages</h2><a href="{{ URL::to_action("messages@new") }}" class="btn right"><i class="icon-envelope"></i> New Message</a></div>
<ol>
@forelse($threads as $thread)
	@if($thread->pivot->unread)
	<li class="unread">
	@else
	<li>
	@endif
	<a href="{{ e("messages/view/{$thread->id}")}}" title="View message">
		<div class="title">
			{{ e($thread->title) }}
		</div>
		<div class="meta">
			@if($thread->starter)
				Thread started by <b>{{$thread->starter->username}}</b> | Last post <b>{{$thread->updated_at}}</b>
			@else
				Thread started by <b>system</b>
			@endif
		</div>
	</a>
	</li>
	@empty
	<li>No messages found</li>
	@endforelse
</ol>
</div>
</div>
@endsection