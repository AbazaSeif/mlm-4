@layout("layout.main")

@section("content")
@include("user.menu")
<div id="content">
	{{ HTML::link_to_action("messages@new", "Send message") }}
	<ul>
	@forelse($threads as $thread)
		@if($thread->pivot->unread)
		<li class="unread">
		@else
		<li>
		@endif
			{{ HTML::link("messages/view/{$thread->id}", $thread->title) }}<br />
			@if($thread->starter)
				Thread started by {{$thread->starter->username}}
			@else
				Thread started by system
			@endif
			<br />
			Last post {{$thread->updated_at}}
		</li>
	@empty
		<li>No messages found</li>
	@endforelse
</div>
@endsection