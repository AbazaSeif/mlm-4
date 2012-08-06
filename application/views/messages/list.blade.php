@layout("layout.main")

@section("content")
<div id="content">
	{{ HTML::link_to_action("messages@new", "Send message") }}
	<ul>
	@forelse($threads as $thread)
		<li>{{ HTML::link("messages/view/{$thread->id}", $thread->title) }}<br />
			@if($thread->starter)
				Thread started by {{$thread->starter->username}}
			@else
				Thread started by system
			@endif
		</li>
	@empty
		<li>No messages found</li>
	@endforelse
</div>
@endsection