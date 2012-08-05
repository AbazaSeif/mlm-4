@layout("layout.main")

@section("content")
<div id="content">
	{{ HTML::link_to_action("messages@new", "Send message") }}
</div>


@endsection