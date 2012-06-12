@layout("layout.admin")

@section("content")
@parent
<div id="content">
	{{ Form::open() }}
	{{ Form::token() }}
	<p>Are you sure you want to delete <strong>{{ e($newsitem->title) }}</strong>?</p>
	{{ Form::submit("Delete", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("admin.news", "Back", array(), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection